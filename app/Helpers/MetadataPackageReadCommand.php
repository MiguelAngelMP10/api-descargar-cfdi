<?php

namespace App\Helpers;

use Illuminate\Console\Command;
use PhpCfdi\SatWsDescargaMasiva\PackageReader\MetadataPackageReader;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;

class MetadataPackageReadCommand extends Command
{
    protected array $data;
    protected MetadataPackageReader $metadataReader;

    protected function processDataTable(MetadataPackageReader $metadataReader)
    {
        $separator = new TableSeparator();
        $headers = $this->getHeadersTable($metadataReader);
        $this->data = [$headers, $separator];

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
            $this->data[] = $this->formatRow($rowMetadata, $headers);
            $bar->advance();
        }
        $bar->finish();
        $this->newLine(2);
        $this->info("CFDIs Current: ${numEnabled}");
        $this->warn("CFDIs Canceled: ${numDisabled}");
        $this->info('The number of records is: ' . $metadataReader->count());
    }

    protected function formatRow($rowMetadata, $headers): array
    {
        if ((int) ($rowMetadata->estatus) === 0) {
            foreach ($headers as $key => $value) {
                $headers[$key] = '<fg=yellow>' . $rowMetadata->$value . '</>';
            }
            return $headers;
        }
        foreach ($headers as $key => $value) {
            $headers[$key] = $rowMetadata->$value;
        }
        return $headers;
    }

    protected function getHeadersTable(MetadataPackageReader $metadataReader): array
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        /** @phpstan-ignore-next-line */
        $headers = array_keys($metadataReader->metadata()->current()->all());
        array_splice($headers, 2, 1);
        array_splice($headers, 3, 1);

        foreach ($headers as $key => $value) {
            $headers[$key] = new TableCell($value, ['style' => $cellStyle]);
        }
        return $headers;
    }

    protected function printTableSummary()
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $this->processDataTable($this->metadataReader);
        $this->table(
            [
                new TableCell(
                    'Metadata Package Read ' . $this->metadataReader->getFilename(),
                    ['colspan' => 10, 'style' => $cellStyle]
                ),
            ],
            $this->data
        );
    }

    protected function countStatusCFDIs(int $status): int
    {
        $count = 0;
        foreach ($this->metadataReader->metadata() as $rowMetadata) {
            if ((int) ($rowMetadata->estatus) === $status) {
                $count++;
            }
        }
        return $count;
    }
}
