<?php

namespace App\Console\Commands;

use App\Console\Traits\ValidateOptionsVerifyQuery;
use App\Helpers\SatWsService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Verify\VerifyResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\ServiceEndpoints;
use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;

class VerifyQuery extends Command
{
    use ValidateOptionsVerifyQuery;

    protected string $logo = <<<EOF
   .______    __    __  .______     ______  _______  _______   __
   |   _  \  |  |  |  | |   _  \   /      ||   ____||       \ |  |
   |  |_)  | |  |__|  | |  |_)  | |  ,----'|  |__   |  .--.  ||  |
   |   ___/  |   __   | |   ___/  |  |     |   __|  |  |  |  ||  |
   |  |      |  |  |  | |  |      |  `----.|  |     |  '--'  ||  |
   | _|      |__|  |__| | _|       \______||__|     |_______/ |__|
EOF;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:verify:query
                            {cer : Certificate path}
                            {key : Key path}
                            {--p|password= : Password FIEL}
                            {--endPoint=cfdi : Service endpoint. [cfdi, retenciones]}
                            {--i|requestId= : Request id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check request status';

    private Fiel $fiel;

    private VerifyResult $verify;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info($this->logo);
        $this->validateData();
        if ($this->validator->passes()) {
            try {
                $this->processFiel();
                if ($this->fiel->isValid()) {
                    $this->processVerifyQuery();
                    $this->tableVerifyQuery();
                    $this->writeQueryResultFile();

                    return 0;
                }

                return 1;
            } catch (Exception $exception) {
                $this->error($exception->getMessage());

                return 1;
            }
        } else {
            $this->printErrors();

            return 1;
        }
    }

    /**
     * @throws Exception
     */
    private function processFiel()
    {
        $contentCer = file_get_contents($this->argument('cer'));
        $contentKey = file_get_contents($this->argument('key'));
        $satWsService = new SatWsService();
        $this->fiel = $satWsService->createFiel(
            $contentCer,
            $contentKey,
            $this->option('password')
        );
    }

    private function processVerifyQuery()
    {
        $webClient = new GuzzleWebClient();
        $requestBuilder = new FielRequestBuilder($this->fiel);
        $endpoints = $this->option('endPoint') === 'cfdi'
            ? ServiceEndpoints::cfdi() : ServiceEndpoints::retenciones();
        $service = new Service($requestBuilder, $webClient, null, $endpoints);
        $this->verify = $service->verify($this->option('requestId'));
    }

    private function printErrors()
    {
        $this->alert('ERRORS');
        foreach ($this->validator->errors()->all() as $error) {
            $this->error($error);
        }
    }

    private function tableVerifyQuery()
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $separator = new TableSeparator();

        $this->table(
            [
                new TableCell('Verify Query', ['colspan' => 6, 'style' => $cellStyle]),
            ],
            [
                [
                    new TableCell('Status', ['colspan' => 2, 'style' => $cellStyle]),
                    new TableCell('Status Request', ['colspan' => 2, 'style' => $cellStyle]),
                    new TableCell('Code Request', ['colspan' => 2, 'style' => $cellStyle]),
                ],
                $separator,
                ['name', 'message', 'name', 'message', 'name', 'message'],
                $separator,
                $this->getMessagesTable(),
                $separator,
                [
                    new TableCell('Number Cfdis', ['colspan' => 3, 'style' => $cellStyle]),
                    new TableCell('Packages Ids', ['colspan' => 3, 'style' => $cellStyle]),
                ],
                $separator,
                $this->getFooterTable($cellStyle),
            ]
        );
    }

    private function getMessagesTable(): array
    {
        return [
            $this->verify->getStatus()->getCode(),
            $this->verify->getStatus()->getMessage(),
            $this->verify->getStatusRequest()->getName(),
            $this->verify->getStatusRequest()->getMessage(),
            $this->verify->getCodeRequest()->getName(),
            $this->verify->getCodeRequest()->getMessage(),
        ];
    }

    private function getFooterTable($cellStyle): array
    {
        return [
            new TableCell($this->verify->getNumberCfdis().'', ['colspan' => 3, 'style' => $cellStyle]),
            new TableCell(
                implode(', ', $this->verify->getPackagesIds()),
                ['colspan' => 3, 'style' => $cellStyle]
            ),
        ];
    }

    private function writeQueryResultFile()
    {
        $nameFile =
            $this->fiel->getRfc().'_'.$this->option('requestId');

        $content = 'Request Id: '.$this->option('requestId').
            "\nPackages Ids: ".implode(', ', $this->verify->getPackagesIds());

        Storage::disk('local')
            ->put('datos/'.$this->fiel->getRfc()
                .'/verify_query/'.$nameFile.'.txt', $content);
        $path = Storage::path('datos/verify_query/'.$this->fiel->getRfc().'/'.$nameFile.'.txt');
        $this->info('The query result is stored in the following path');
        $this->info($path);
    }
}
