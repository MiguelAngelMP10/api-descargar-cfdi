<?php

namespace App\Console\Commands;

use App\Helpers\MetadataPackageReadCommand;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\Exceptions\OpenZipFileException;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\MetadataPackageReader;

class MetadataPackageRead extends MetadataPackageReadCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:metadata:package:reader
                            {path : Zip file path the metadata}
                            {--C|count : Number of records}
                            {--S|status= : Status CFDI}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the content of a metadata zip in table format.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->processCommand();
            return 0;
        } catch (OpenZipFileException $exception) {
            $this->error($exception->getMessage());
            return 1;
        }
    }

    private function processCommand(): void
    {
        $this->metadataReader = MetadataPackageReader::createFromFile($this->argument('path'));

        if (! is_null($this->option('status')) && (int) $this->option('status') === 1) {
            $this->info('The number of records CURRENT is: ' . $this->countStatusCFDIs(1));
            return;
        }

        if (! is_null($this->option('status')) && (int) $this->option('status') === 0) {
            $this->warn('The number of records CANCELED is: ' . $this->countStatusCFDIs(0));
            return;
        }

        if ($this->option('count')) {
            $this->info('The number of records is: ' . $this->metadataReader->count());
        } else {
            $this->printTableSummary();
        }
    }
}
