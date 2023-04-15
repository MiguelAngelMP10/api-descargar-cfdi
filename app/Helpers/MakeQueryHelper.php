<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MakeQueryPostRequest;
use App\Traits\AddParametersToQuery;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;

class MakeQueryHelper extends Controller
{
    use AddParametersToQuery;

    protected string $cer;
    protected string $key;
    protected string $password;
    protected string|null $endPoint;
    protected array $rfcMatches;
    protected DownloadType $downloadType;
    protected RequestType $requestType;
    protected DateTimePeriod $period;
    protected QueryParameters $queryParameters;

    /**
     * @param MakeQueryPostRequest $request
     *
     * @return void
     */
    protected function getParamsQuery(MakeQueryPostRequest $request): void
    {
        $this->cer = $request->input('cer');
        $this->key = $request->input('key');
        $this->password = $request->input('password');
        $this->endPoint = $request->input('endPoint');

        $start = $request->input('period.start');
        $end = $request->input('period.end');

        $this->downloadType = $request->input('downloadType') === 'issued'
            ? DownloadType::issued() : DownloadType::received();

        $this->requestType = $request->input('requestType') === 'xml'
            ? RequestType::xml() : RequestType::metadata();

        $this->rfcMatches = $request->has('rfcMatches') ? $request->input('rfcMatches') : [];

        $this->period = DateTimePeriod::createFromValues($start, $end);
    }
}
