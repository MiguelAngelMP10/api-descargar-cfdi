<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUserSuccessfullyWhenUserNotExists(): void
    {
        $faker = Factory::create();

        $this->artisan('user:create')
            ->expectsQuestion('What is your name?', $faker->firstName)
            ->expectsQuestion('What is your email?', $faker->email)
            ->expectsQuestion('What is your password?', $faker->password)
            ->assertExitCode(0);
    }

    public function testOutputErrorWhenUserAlreadyExists(): void
    {
        $email = 'fake@mail.com';

        User::create([
            'name' => 'Test',
            'email' => $email,
            'password' => Hash::make('password')
        ]);

        $faker = Factory::create();

        $this->artisan('user:create')
            ->expectsQuestion('What is your name?', $faker->firstName)
            ->expectsQuestion('What is your email?', $email)
            ->expectsQuestion('What is your password?', $faker->password)
            ->assertExitCode(1);
    }
}
