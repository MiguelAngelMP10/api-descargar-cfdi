<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;

class SendCerKeyTest extends TestCase
{
    private string $pathCer = 'tests/_files/fake-fiel/EKU9003173C9.cer';

    private string $pathKey = 'tests/_files/fake-fiel/EKU9003173C9.key';

    private string $password = '12345678a';

    public function test_failed_command()
    {
        $this->artisan('sw:send:cer-key '.$this->pathCer.' '.$this->pathKey)
            ->expectsQuestion('What is the password?', 'lo*que*sea')
            ->expectsQuestion('Do you want your FIEL to be stored in our local storage?', 'No')
            ->assertFailed();
    }

    public function test_successful_command()
    {
        $this->artisan('sw:send:cer-key '.$this->pathCer.' '.$this->pathKey)
            ->expectsQuestion('What is the password?', $this->password)
            ->expectsQuestion('Do you want your FIEL to be stored in our local storage?', 'No')
            ->assertSuccessful();
    }

    public function test_cer_and_key_empty_command()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Not enough arguments (missing: "cer, key").');
        $this->artisan('sw:send:cer-key ');
    }

    public function test_test_successful_command_full_one_line()
    {
        $commandFull = 'sw:send:cer-key '.$this->pathCer.' '
            .$this->pathKey.' -p '.$this->password.' --copyFiel No';
        $this->artisan($commandFull)
            ->assertSuccessful();
    }
}
