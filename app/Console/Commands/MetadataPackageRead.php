<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\Exceptions\OpenZipFileException;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\MetadataPackageReader;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;

class MetadataPackageRead extends Command
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

    private array $data;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $metadataReader = MetadataPackageReader::createFromFile($this->argument('path'));

            if (! is_null($this->option('status')) && (int) $this->option('status') === 1) {
                $this->info('The number of records CURRENT is: ' . $this->countStatusCFDIs($metadataReader, 1));
                return 0;
            }

            if (! is_null($this->option('status')) && (int) $this->option('status') === 0) {
                $this->warn('The number of records CANCELED is: ' . $this->countStatusCFDIs($metadataReader, 0));
                return 0;
            }

            if ($this->option('count')) {
                $this->info('The number of records is: ' . $metadataReader->count());
            } else {
                $this->printTableSummary($metadataReader);
            }
            return 0;
        } catch (OpenZipFileException $exception) {
            $this->error($exception->getMessage());
            return 1;
        }
    }

    private function printTableSummary($metadataReader)
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $this->addTitlesBodyTable($cellStyle);
        $this->processDataTable($metadataReader);
        $this->table(
            [
                new TableCell(
                    'Metadata Package Read ' . $metadataReader->getFilename(),
                    ['colspan' => 10, 'style' => $cellStyle]
                ),
            ],
            $this->data
        );
    }

    private function addTitlesBodyTable($cellStyle)
    {
        $separator = new TableSeparator();
        $this->data = [
            [
                new TableCell('uuid', ['style' => $cellStyle]),
                new TableCell('Rfc Emisor', ['style' => $cellStyle]),
                new TableCell('Rfc Receptor', ['style' => $cellStyle]),
                new TableCell('Rfc Pac', ['style' => $cellStyle]),
                new TableCell('Fecha Emision', ['style' => $cellStyle]),
                new TableCell('Fecha Certificacion Sat', ['style' => $cellStyle]),
                new TableCell('Monto', ['style' => $cellStyle]),
                new TableCell('Efecto', ['style' => $cellStyle]),
                new TableCell('Estatus', ['style' => $cellStyle]),
                new TableCell('Fecha Cancelacion', ['style' => $cellStyle]),
            ],
            $separator,
        ];
    }

    private function countStatusCFDIs($metadataReader, $status): int
    {
        $count = 0;
        foreach ($metadataReader->metadata() as $rowMetadata) {
            if ((int) ($rowMetadata->estatus) === $status) {
                $count++;
            }
        }
        return $count;
    }

    private function processDataTable($metadataReader)
    {
        $this->newLine(2);
        $bar = $this->output->createProgressBar($metadataReader->count());
        $bar->setFormat('debug');
        $bar->start();
        $numEnabled = 0;
        $numDisabled = 0;
        foreach ($metadataReader->metadata() as $rowMetadata) {
            if ((int) ($rowMetadata->estatus) === 1) {
                $numEnabled++;
            } else {
                $numDisabled++;
            }
            $this->data[] = $this->formatCell($rowMetadata);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
        $this->info("CFDIs Current: ${numEnabled}");
        $this->warn("CFDIs Canceled: ${numDisabled}");

        $this->info('The number of records is: ' . $metadataReader->count());
    }

    private function formatCell($rowMetadata): array
    {
        if ((int) ($rowMetadata->estatus) === 0) {
            return [
                '<fg=yellow>' . $rowMetadata->uuid . '</>',
                '<fg=yellow>' . $rowMetadata->rfcEmisor . '</>',
                '<fg=yellow>' . $rowMetadata->rfcReceptor . '</>',
                '<fg=yellow>' . $rowMetadata->rfcPac . '</>',
                '<fg=yellow>' . $rowMetadata->fechaEmision . '</>',
                '<fg=yellow>' . $rowMetadata->fechaCertificacionSat . '</>',
                '<fg=yellow>' . $rowMetadata->monto . '</>',
                '<fg=yellow>' . $rowMetadata->efectoComprobante . '</>',
                '<fg=yellow>' . $rowMetadata->estatus . '</>',
                '<fg=yellow>' . $rowMetadata->fechaCancelacion . '</>',
            ];
        }
        return [
            $rowMetadata->uuid,
            $rowMetadata->rfcEmisor,
            $rowMetadata->rfcReceptor,
            $rowMetadata->rfcPac,
            $rowMetadata->fechaEmision,
            $rowMetadata->fechaCertificacionSat,
            $rowMetadata->monto,
            $rowMetadata->efectoComprobante,
            $rowMetadata->estatus,
            $rowMetadata->fechaCancelacion,
        ];
    }
}
