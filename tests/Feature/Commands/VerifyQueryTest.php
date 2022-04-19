<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;
use Tests\TestCase;

class VerifyQueryTest extends TestCase
{
    private string $pathCer = "tests/_files/fake-fiel/EKU9003173C9.cer";
    private string $pathKey = "tests/_files/fake-fiel/EKU9003173C9.key";
    private string $plainText = "tests/_files/plain-text.txt";
    private string $password = '12345678a';

    public function test_cer_and_key_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->artisan('sw:verify:query');
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
    }

    public function test_password_required()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey)
            ->expectsOutput('The password field is required.')
            ->assertFailed();
    }

    public function test_password_min_5_characters()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey . ' -p 123')
            ->expectsOutput('The password must be at least 5 characters.')
            ->assertFailed();
    }

    public function test_end_point_required()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . ' --endPoint=')
            ->expectsOutput('The endPoint field is required.')
            ->assertFailed();
    }

    public function test_end_point_in()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . ' --endPoint=thing ')
            ->expectsOutput('The endPoint must be one of the following types: cfdi, retenciones.')
            ->assertFailed();
    }

    public function test_request_id_required()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password)
            ->expectsOutput('The requestId field is required.')
            ->assertFailed();
    }

    public function test_request_id_type_uuid()
    {
        $this->artisan('sw:verify:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . ' -i 123')
            ->expectsOutput('The requestId must be a valid UUID.')
            ->assertFailed();
    }

    public function test_table_verify_query()
    {
        $cellStyle = new TableCellStyle(['align' => 'center', 'fg' => 'green']);
        $separator = new TableSeparator();

        $command = "sw:verify:query $this->pathCer $this->pathKey
                        -p $this->password
                        -i '865ccb11-5072-4849-be37-640d16c50aee'";

        $this->artisan($command)->expectsTable([
            new TableCell('Verify Query', ['colspan' => 6, 'style' => $cellStyle]),
        ], [
            [
                new TableCell('Status', ['colspan' => 2, 'style' => $cellStyle]),
                new TableCell('Status Request', ['colspan' => 2, 'style' => $cellStyle]),
                new TableCell('Code Request', ['colspan' => 2, 'style' => $cellStyle]),
            ],
            $separator,
            ['name', 'message', 'name', 'message', 'name', 'message'],
            $separator,
            ['305', 'Certificado Inválido', 'Unknown', 'Desconocida', 'Unknown', 'Desconocida'],
            $separator,
            [
                new TableCell('Number Cfdis', ['colspan' => 3, 'style' => $cellStyle]),
                new TableCell('Packages Ids', ['colspan' => 3, 'style' => $cellStyle]),
            ],
            $separator,
            [
                new TableCell('0', ['colspan' => 3, 'style' => $cellStyle]),
                new TableCell('', ['colspan' => 3, 'style' => $cellStyle]),
            ]
        ]);
    }

    public function test_write_query_result_file()
    {
        $command = "sw:verify:query $this->pathCer $this->pathKey
                        -p $this->password
                        -i '865ccb11-5072-4849-be37-640d16c50aee'";

        $this->artisan($command)->expectsOutput('The query result is stored in the following path');
    }
}
