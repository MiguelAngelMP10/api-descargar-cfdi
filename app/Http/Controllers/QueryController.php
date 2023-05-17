<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQueryRequest;
use App\Models\Query;
use App\Traits\AddParametersToQuery;
use App\Traits\DecryptFiel;
use App\Traits\ParameterEvaluations;
use App\Utils\ComplementoCfdiList;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

class QueryController extends Controller
{
    use AddParametersToQuery;
    use DecryptFiel;
    use ParameterEvaluations;

    public const FORMAT_DATE = 'Y-m-d H:i:s';

    protected QueryParameters $queryParameters;

    private array $rfcMatches;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response|ResponseFactory
    {
        $queries = $request->user()->queries()->with(['packeges'])
            ->when($request->search, function ($query, $search) {
                $query->where('rfc', 'like', '%'.$search.'%')
                    ->orWhere('endPoint', 'like', '%'.$search.'%')
                    ->orWhere('downloadType', 'like', '%'.$search.'%')
                    ->orWhere('requestType', 'like', '%'.$search.'%');
            })->paginate(10)->withQueryString();

        return Inertia('Queries/Index', [
            'queries' => $queries,
            'search' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response|ResponseFactory
    {
        return Inertia(
            'Queries/Create',
            [
                'endpoint' => ['cfdi' => 'Cfdi', 'retenciones' => 'Retenciones'],
                'downloadType' => ['issued' => 'Issued (Emitidos)', 'received' => 'Received (Recibidos)'],
                'requestType' => ['xml' => 'Xml', 'metadata' => 'Metadata'],
                'documentType' => [
                    '' => 'Undefined',
                    'I' => 'Ingreso',
                    'E' => 'Egreso',
                    'T' => 'Traslado',
                    'N' => 'Nómina',
                    'P' => 'Pago',
                ],
                'complementoCfdi' => ComplementoCfdiList::COMPLEMENTOS_CFDI_LIST,
                'documentStatus' => ['undefined' => 'Undefined', 'active' => 'Active', 'cancelled' => 'Cancelled'],
                'fiels' => $request->user()->fiels()->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQueryRequest $request): RedirectResponse
    {
        try {
            $fielDB = $request->user()->fiels()->where('rfc', $request->input('rfc'))->first();
            $requestBuilder = new FielRequestBuilder($this->decryptFiel($fielDB));
            $webclient = new GuzzleWebClient();
            $message = '';
            foreach ($request->input('endPoint') as $endPoint) {
                foreach ($request->input('downloadType') as $downloadType) {
                    foreach ($request->input('requestType') as $requestType) {
                        $service = new Service($requestBuilder, $webclient, null, $this->getEndpoints($endPoint));
                        $this->queryParameters = QueryParameters::create()
                            ->withDownloadType($this->getDownloadType($downloadType))
                            ->withRequestType($this->getRequestType($requestType));
                        $this->processParams($request);
                        $query = $service->query($this->queryParameters);
                        $this->insertQuery($request, $endPoint, $downloadType, $requestType, $query);
                        $message .= 'Queries created successfully <br>RequestId: '.$query->getRequestId().'<br>';
                    }
                }
            }

            return redirect()->route('queries.create')->with('success', $message);
        } catch (Exception $exception) {
            return redirect()->route('queries.create')->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Query $query): Response|ResponseFactory
    {
        $queryR = Query::where('id', '=', $query->id)->with(['resposesQuery', 'packeges'])->first();

        return Inertia('Queries/Show', [
            'query' => $queryR,
        ]);
    }

    private function calculateStartAndEndPeriod($request): void
    {
        if ($request->input('period_start') !== null && $request->input('period_end') !== null) {
            $start = Carbon::createFromFormat('Y-m-d', $request->input('period_start'));
            $end = Carbon::createFromFormat('Y-m-d', $request->input('period_end'));
            $start->setHour(0)->setMinutes(0)->setSecond(0)->toDate();
            $end->setHour(23)->setMinutes(59)->setSecond(59)->toDate();
            $start = $start->format('Y-m-d H:i:s');
            $end = $end->format('Y-m-d H:i:s');
            $this->queryParameters = $this->queryParameters->withPeriod(DateTimePeriod::createFromValues($start, $end));
        }
    }

    private function processParams($request): void
    {
        $this->calculateStartAndEndPeriod($request);
        $this->addDocumentTypeToQueryParameters($request);
        $this->addComplementoCfdi($request);
        $this->addDocumentStatus($request);
        $this->addUuid($request);
        $this->addRfcOnBehalf($request);
        $this->rfcMatches = $request->has('rfcMatches') ? $request->input('rfcMatches') : [];
        $this->addRfcMatches();
    }

    private function insertQuery($request, $endPoint, $downloadType, $requestType, $query): void
    {
        $request->user()->queries()->create([
            'rfc' => $request->input('rfc'),
            'endPoint' => $endPoint,
            'downloadType' => $downloadType,
            'requestType' => $requestType,
            'dateTimePeriodStart' => $this->queryParameters->getPeriod()
                ->getStart()->format(self::FORMAT_DATE),
            'dateTimePeriodEnd' => $this->queryParameters->getPeriod()
                ->getEnd()->format(self::FORMAT_DATE),
            'requestId' => $query->getRequestId(),
            'documentType' => $this->queryParameters->getDocumentType()->value(),
            'documentStatus' => $this->queryParameters->getDocumentStatus()->value(),
            'complementoCfdi' => $this->queryParameters->getComplement()->value(),
            'rfcMatches' => json_encode($this->queryParameters->getRfcMatches()),
            'rfcOnBehalf' => $this->queryParameters->getRfcOnBehalf()->getValue(),
            'uuid' => $this->queryParameters->getUuid()->getValue(),
            'statusCode' => $query->getStatus()->getCode(),
            'statusMessage' => $query->getStatus()->getMessage(),
        ]);
    }
}
