<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /** @var string */
    protected $signature = 'user:create';

    /** @var string */
    protected $description = 'This command is used to create users';

    public function handle(): int
    {
        $name = $this->untilFull('What is your name?');
        $email = $this->untilFull('What is your email?');
        $password = $this->untilFull('What is your password?', true);

        $user = User::where('email', $email)->first();

        if ($user !== null) {
            $this->output->error("The user with email {$email} already exists");

            return 1;
        }

        /** @var User|null $user */
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->line("The user has been created with id: {$user->id}");

        return 0;
    }

    protected function untilFull(string $question, bool $secret = false): string
    {
        do {
            $value = $secret ? $this->secret($question) : $this->ask($question);
        } while ($value === '');

        return $value;
    }
}
