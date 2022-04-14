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

}
