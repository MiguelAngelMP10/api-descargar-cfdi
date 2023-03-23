<?php

namespace Tests\Feature\Commands;

use App\Utils\ComplementoCfdiList;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Tests\TestCase;

class MakeQueryTest extends TestCase
{
    private string $pathCer = "tests/_files/fake-fiel/EKU9003173C9.cer";
    private string $pathKey = "tests/_files/fake-fiel/EKU9003173C9.key";
    private string $plainText = "tests/_files/plain-text.txt";

    private string $password = '12345678a';

    public function test_cer_and_key_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
        $this->artisan('sw:make:query ');
    }

    public function test_password_required()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey)
            ->expectsOutput('The password field is required.')
            ->assertFailed();
    }

    public function test_password_min_5_characters()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey . ' -p 123')
            ->expectsOutput('The password must be at least 5 characters.')
            ->assertFailed();
    }

    public function test_endPoint_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . ' --endPoint=thing ')
            ->expectsOutput('The endPoint must be one of the following types: cfdi, retenciones.')
            ->assertFailed();
    }

    public function test_period_star_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -s "another-thing" -p ' . $this->password)
            ->expectsOutput('The period star is not a valid date.')
            ->expectsOutput('The period star does not match the format Y-m-d H:i:s.')
            ->assertFailed();
    }

    public function test_period_end_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey . ' -p "' . $this->password .
            '" -s "2019-01-13 00:00:00" -e "otra"')
            ->expectsOutput('The period end is not a valid date.')
            ->expectsOutput('The period end does not match the format Y-m-d H:i:s.')
            ->assertFailed();
    }

    public function test_request_type_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey . ' -p "' . $this->password .
            '" --requestType=another-thing ')
            ->expectsOutput('The requestType must be one of the following types: xml, metadata.')
            ->assertFailed();
    }

    public function test_download_type_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey . ' -p "' . $this->password .
            '" --downloadType=another-thing')
            ->expectsOutput('The downloadType must be one of the following types: issued, received.')
            ->assertFailed();
    }

    public function test_document_type_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . '" --documentType=thing')
            ->expectsOutput('The documentType must be one of the following types: I, E, T, N, P, U.')
            ->assertFailed();
    }

    public function test_complement_cfdi_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . '" --complementCfdi=thing')
            ->expectsOutput('The complementCfdi must be one of the following types: ' .
                implode(', ', array_keys(ComplementoCfdiList::COMPLEMENTOS_CFDI_LIST)) . '.')
            ->assertFailed();
    }

    public function test_document_status_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . '" --documentStatus=thing')
            ->expectsOutput('The documentStatus must be one of the following types: undefined, active, cancelled.')
            ->assertFailed();
    }

    public function test_uuid_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . '" --uuid=thing')
            ->expectsOutput('The uuid must be a valid UUID.')
            ->assertFailed();
    }

    public function test_rfc_on_behalf_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . '" --rfcOnBehalf=thing')
            ->expectsOutput('The rfcOnBehalf field not appears to be valid.')
            ->assertFailed();
    }

    public function test_rfc_match_validate()
    {
        $this->artisan('sw:make:query ' . $this->pathCer . ' ' . $this->pathKey .
            ' -p "' . $this->password . ' --rfcMatch=uno --rfcMatch=dos --rfcMatch=test')
            ->expectsOutput('The rfcMatch.0 field not appears to be valid.')
            ->expectsOutput('The rfcMatch.1 field not appears to be valid.')
            ->expectsOutput('The rfcMatch.2 field not appears to be valid.')
            ->assertFailed();
    }

    public function test_fiel_invalidate()
    {
        $this->artisan('sw:make:query ' . $this->plainText . ' ' . $this->plainText . ' -p ' . $this->password)
            ->expectsOutput('Cannot parse X509 certificate from contents');
    }

    public function test_fiel_private_key_invalidate()
    {
        $command = 'sw:make:query ' . $this->pathCer . ' ' . $this->plainText . ' -p ' . $this->password;
      $this->artisan($command)->assertFailed();
    }


    public function test_confirm_newQuery()
    {
        $command = "sw:make:query $this->pathCer  $this->pathKey -p $this->password
        -s '2019-01-13 00:00:00'
        -e '2019-01-13 23:59:59'
        --requestType='metadata'
        --downloadType='issued'
        --documentType='N'
        --complementCfdi='nomina11'
        --documentStatus='active'
         -u '96623061-61fe-49de-b298-c7156476aa8b'
         --rfcOnBehalf='XXX01010199A'";

        $this->artisan($command)
            ->expectsConfirmation('Are you sure you submit this query with the above parameters?', 'Yes')
            ->assertSuccessful();
    }

    public function test_table_query_summary()
    {
        $separator = new TableSeparator();
        $command = "sw:make:query $this->pathCer  $this->pathKey -p $this->password
        -s '2019-01-13 00:00:00'
        -e '2019-01-13 23:59:59'
        --requestType='metadata'
        --downloadType='issued'
        --documentType='N'
        --complementCfdi='nomina11'
        --documentStatus='active'
         -u '96623061-61fe-49de-b298-c7156476aa8b'
         --rfcOnBehalf='XXX01010199A'";

        $this->artisan($command)
            ->expectsTable([new TableCell('Query summary', ['colspan' => 2])], [
                ['Data', 'Value'],
                [new TableCell('Period', ['colspan' => 2])],
                $separator,
                ['Start', '2019-01-13T00:00:00.000UTC'],
                ['End', '2019-01-13T23:59:59.000UTC'],
                $separator,
                ['Download Type', 'RfcEmisor'],
                ['Document Type', 'N'],
                ['Request Type', 'metadata'],
                ['Complemento Cfdi', 'nomina11'],
                ['uuid', '96623061-61fe-49de-b298-c7156476aa8b'],
                ['rfcOnBehalf', 'XXX01010199A'],
                ['rfcMatches',],
            ], 'default');
    }

    public function test_table_result_query()
    {
        $separator = new TableSeparator();
        $command = "sw:make:query $this->pathCer  $this->pathKey -p $this->password";
        $this->artisan($command)
            ->expectsConfirmation('Are you sure you submit this query with the above parameters?', 'Yes')
            ->expectsTable(
                [new TableCell('Data Result Query', ['colspan' => 2])],
                [
                    [new TableCell('Status', ['colspan' => 2])],
                    $separator,
                    ['Code', '305'],
                    ['Message', 'Certificado Inválido'],
                    ['RequestId', ''],
                ]
            );
    }

    public function test_write_query_result_file()
    {
        $command = "sw:make:query $this->pathCer  $this->pathKey -p $this->password
        -s '2019-01-13 00:00:00'
        -e '2019-01-13 23:59:59'
        --requestType='metadata'
        --downloadType='issued'
        --documentType='N'
        --complementCfdi='nomina11'
        --documentStatus='active'
         -u '96623061-61fe-49de-b298-c7156476aa8b'
         --rfcOnBehalf='XXX01010199A'";

        $this->artisan($command)
            ->expectsConfirmation('Are you sure you submit this query with the above parameters?', 'Yes')
            ->expectsOutput('The query result is stored in the following path');
    }
}
