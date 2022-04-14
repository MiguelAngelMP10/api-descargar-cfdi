<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VerifyQuery extends Command
{
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
                            {--i|requestId : Request id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check request status';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return 0;
    }
}
