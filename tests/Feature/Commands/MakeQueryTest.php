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
}
