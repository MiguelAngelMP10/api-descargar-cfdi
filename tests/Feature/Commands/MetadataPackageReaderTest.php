<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;
use Tests\TestCase;

class MetadataPackageReaderTest extends TestCase
{
    private string $plainText = "tests/_files/plain-text.txt";
    private string $fakeMetadataNormal = "tests/_files/metadata_normal.zip";
    private string $fakeMetadataRetencionNormal = 'tests/_files/metadata_retencion_pagos.zip';

    public function test_path_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->artisan('sw:metadata:package:reader');
        $this->expectExceptionMessage('Not enough arguments (missing: "path").');
    }

    public function test_file_invalid()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->plainText)
            ->expectsOutput('Unable to open Zip file tests/_files/plain-text.txt')
            ->assertFailed();
    }

    public function test_print_table_metadata_cfdi_normal()
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $separator = new TableSeparator();
        $command = 'sw:metadata:package:reader ' . $this->fakeMetadataNormal;
        $test = $this->artisan($command);
        $test->expectsTable(
            [
                new TableCell(
                    'Metadata Package Read tests/_files/metadata_normal.zip',
                    ['colspan' => 10, 'style' => $cellStyle]
                ),
            ],
            [
                [
                    new TableCell('uuid', ['style' => $cellStyle]),
                    new TableCell('rfcEmisor', ['style' => $cellStyle]),
                    new TableCell('rfcReceptor', ['style' => $cellStyle]),
                    new TableCell('rfcPac', ['style' => $cellStyle]),
                    new TableCell('fechaEmision', ['style' => $cellStyle]),
                    new TableCell('fechaCertificacionSat', ['style' => $cellStyle]),
                    new TableCell('monto', ['style' => $cellStyle]),
                    new TableCell('efectoComprobante', ['style' => $cellStyle]),
                    new TableCell('estatus', ['style' => $cellStyle]),
                    new TableCell('fechaCancelacion', ['style' => $cellStyle]),
                    new TableCell('rfcACuentaTerceros', ['style' => $cellStyle]),
                    new TableCell('nombreACuentaTerceros', ['style' => $cellStyle]),
                ],
                $separator,
                [
                    '4A00D136-FA2E-499C-AFA8-6758A9E5A9C5',
                    'EKU9003173C9',
                    'MISC491214B86',
                    'SAT970701NN3',
                    '2021-03-05 00:41:01',
                    '2021-03-05 00:50:45',
                    '8275.86',
                    'I',
                    '1',
                    '',
                    '',
                    ''
                ]
            ]
        );
    }

    public function test_print_table_metadata_retencion_pagos()
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $separator = new TableSeparator();
        $command = 'sw:metadata:package:reader ' . $this->fakeMetadataRetencionNormal;
        $test = $this->artisan($command);
        $test->expectsTable(
            [
                new TableCell(
                    'Metadata Package Read tests/_files/metadata_retencion_pagos.zip',
                    ['colspan' => 10, 'style' => $cellStyle]
                ),
            ],
            [
                [
                    new TableCell('uuid', ['style' => $cellStyle]),
                    new TableCell('rfcEmisor', ['style' => $cellStyle]),
                    new TableCell('rfcReceptor', ['style' => $cellStyle]),
                    new TableCell('rfcPac', ['style' => $cellStyle]),
                    new TableCell('fechaEmision', ['style' => $cellStyle]),
                    new TableCell('fechaCertificacionSat', ['style' => $cellStyle]),
                    new TableCell('montoOp', ['style' => $cellStyle]),
                    new TableCell('montoRet', ['style' => $cellStyle]),
                    new TableCell('estatus', ['style' => $cellStyle]),
                    new TableCell('fechaCancelacion', ['style' => $cellStyle]),
                    new TableCell('rfcACuentaTerceros', ['style' => $cellStyle]),
                    new TableCell('nombreACuentaTerceros', ['style' => $cellStyle]),
                ],
                $separator,
                [
                    '301885b5-bc0d-42de-bf8f-cbd1ff228905',
                    'MISC491214B86',
                    '',
                    'FUNK671228PH6',
                    '2017-02-02 17:48:18',
                    '2017-02-02 11:50:04',
                    '4495833.0000',
                    '674375.0000',
                    '1',
                    '',
                    '',
                    ''
                ]
            ]
        );
    }

    public function test_metadata_cfdi_normal_count_all()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataNormal . ' -C')
            ->expectsOutput('The number of records is: 1');
    }

    public function test_metadata_cfdi_normal_count_canceled()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataNormal . ' -C -S 0')
            ->expectsOutput('The number of records CANCELED is: 0');
    }

    public function test_metadata_cfdi_normal_count_current()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataNormal . ' -C -S 1')
            ->expectsOutput('The number of records CURRENT is: 1');
    }

    public function test_metadata_retencion_pagos_count_all()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataRetencionNormal)
            ->expectsOutput('The number of records is: 1');
    }

    public function test_metadata_retencion_pagos_count_canceled()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataRetencionNormal . ' -C -S 0')
            ->expectsOutput('The number of records CANCELED is: 0');
    }

    public function test_metadata_retencion_pagos_count_current()
    {
        $this->artisan('sw:metadata:package:reader ' . $this->fakeMetadataRetencionNormal . ' -C -S 1')
            ->expectsOutput('The number of records CURRENT is: 1');
    }
}
