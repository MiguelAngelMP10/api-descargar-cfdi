<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeQuery extends Command
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
                             {--p|password= : Paswword FIEL}

                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' Create a query before the mass download web services before the SAT';
    /**
     * @var array|string
     */
    private $localStore;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

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
