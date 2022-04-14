<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $this->artisan('sw:make:query sw:verify:query');
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
    }

}
