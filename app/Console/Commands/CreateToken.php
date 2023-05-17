<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateToken extends Command
{
    /** @var string */
    protected $signature = 'token:create {user} {--name=}';

    /** @var string */
    protected $description = 'This command is used to create tokens';

    public function handle(): int
    {
        $userId = $this->argument('user');

        /** @var User|null $user */
        $user = User::find($userId);

        if ($user === null) {
            $this->output->error("The user with id {$userId} not exists");

            return 1;
        }

        $token = $user->createToken($this->option('name') ?? '');

        $this->output->success("The token was created, value: {$token->plainTextToken}");

        return 0;
    }
}
