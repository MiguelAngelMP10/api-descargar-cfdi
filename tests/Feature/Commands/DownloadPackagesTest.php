<?php

namespace Tests\Feature\Commands;

use Faker\Provider\Uuid;
use Tests\TestCase;

class DownloadPackagesTest extends TestCase
{
    private string $pathCer = "tests/_files/fake-fiel/EKU9003173C9.cer";
    private string $pathKey = "tests/_files/fake-fiel/EKU9003173C9.key";
    private string $plainText = "tests/_files/plain-text.txt";
    private string $password = '12345678a';

    public function test_cer_and_key_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->artisan('sw:download:packages ');
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
    }

    public function test_password_required()
    {
        $this->artisan('sw:download:packages ' . $this->pathCer . ' ' . $this->pathKey)
            ->expectsOutput('The password field is required.')
            ->assertFailed();
    }
}
