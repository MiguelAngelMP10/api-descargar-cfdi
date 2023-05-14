<?php

namespace App\Console\Commands;

use App\Helpers\MakeQueryCommand;
use App\Helpers\SatWsService;
use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;

class MakeQuery extends MakeQueryCommand
{
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
    protected $signature = 'sw:make:query
                            {cer : Certificate path}
                            {key : Key path}
                            {--p|password= : Password FIEL}

                            {--endPoint=cfdi : Service endpoint. [cfdi, retenciones]}

                            {--s|periodStar= : Start date and time in format YYYY-MM-dd hh:mm:ss}

                            {--e|periodEnd= : End date and time in format YYYY-MM-dd hh:mm:ss}

                            {--requestType=metadata : Specifies whether the request is for Metadata or XML files.'.
    ' [metadata, xml]}

                            {--downloadType=issued : Specifies whether the request is for issued or '.
    'received documents. [issued, received]}

                            {--documentType=U : Filter the request by type [E, I, N, P, T, U]}

                            {--complementCfdi= : Filters the request by the existence of a complementCfdi}

                            {--documentStatus=undefined : Filter the request by the document status: '.
    '[undefined, active, cancelled]}

                            {--u|uuid= : Filter the request by UUID.}

                            {--rfcOnBehalf= : Filters the request by the RFC used on behalf of third parties.}

                            {--rfcMatch=* : Filtered by RFC counterpart}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a query before the mass download web services before the SAT';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info($this->logo);
        $this->validateOptions();
        $this->makeQuery();

        return $this->exitCode;
    }

    private function makeQuery(): void
    {
        if ($this->exitCode === 0) {
            try {
                $contentCer = file_get_contents($this->argument('cer'));
                $contentKey = file_get_contents($this->argument('key'));
                $satWsService = new SatWsService();
                $this->fiel = $satWsService->createFiel(
                    $contentCer,
                    $contentKey,
                    $this->data['password']
                );

                if ($this->fiel->isValid()) {
                    $this->queryParameters = QueryParameters::create();
                    $this->addParametersQuery();
                    $this->querySummary();

                    if ($this->confirm('Are you sure you submit this query with the above parameters?', true)) {
                        $this->presentQuery();
                        $this->exitCode = 0;
                    }
                }

                return;
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
                $this->exitCode = 1;
            }
        }
    }
}
