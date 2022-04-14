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
}
