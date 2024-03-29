<?php

namespace Tests\Feature\Commands;

use Faker\Provider\Uuid;
use Tests\TestCase;

class DownloadPackagesTest extends TestCase
{
    private string $pathCer = 'tests/_files/fake-fiel/EKU9003173C9.cer';

    private string $pathKey = 'tests/_files/fake-fiel/EKU9003173C9.key';

    private string $plainText = 'tests/_files/plain-text.txt';

    private string $password = '12345678a';

    public function test_cer_and_key_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->artisan('sw:download:packages ');
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
    }

    public function test_password_required()
    {
        $this->artisan('sw:download:packages '.$this->pathCer.' '.$this->pathKey)
            ->expectsOutput('The password field is required.')
            ->assertFailed();
    }

    public function test_password_min_5_characters()
    {
        $this->artisan('sw:download:packages  '.$this->pathCer.' '.$this->pathKey.' -p 123')
            ->expectsOutput('The password must be at least 5 characters.')
            ->assertFailed();
    }

    public function test_end_point_required()
    {
        $this->artisan('sw:download:packages '.$this->pathCer.' '.$this->pathKey.
            ' -p "'.$this->password.' --endPoint=')
            ->expectsOutput('The endPoint field is required.')
            ->assertFailed();
    }

    public function test_end_point_in()
    {
        $this->artisan('sw:download:packages '.$this->pathCer.' '.$this->pathKey.
            ' -p "'.$this->password.' --endPoint=thing ')
            ->expectsOutput('The endPoint must be one of the following types: cfdi, retenciones.')
            ->assertFailed();
    }

    public function test_packages_id_required()
    {
        $this->artisan('sw:download:packages '.$this->pathCer.' '.$this->pathKey.' -p '.$this->password)
            ->expectsOutput('The package id field is required.')
            ->assertFailed();
    }

    public function test_multiple_packages_id()
    {
        $packageid = Uuid::uuid();
        $stringPakages = '';
        for ($i = 0; $i < 10; $i++) {
            $stringPakages .= " -i '{$packageid}_0{$i}'";
        }
        $command = "sw:download:packages $this->pathCer $this->pathKey -p $this->password $stringPakages ";
        $test = $this->artisan($command);
        for ($i = 0; $i < 10; $i++) {
            $test->expectsOutput("The package {$packageid}_0{$i} unable to download: Certificado Inválido");
        }
        $test->assertSuccessful();
    }
}
