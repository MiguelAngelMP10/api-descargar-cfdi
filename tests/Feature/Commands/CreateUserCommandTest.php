<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @see CreateUser::handle()
     * @test
     */
    public function create_user_successfully_when_user_not_exists(): void
    {
        $expectedPassword = 'MyPassword';
        $user = User::factory()->make([
            'password' => $expectedPassword,
        ]);

        $this->artisan('user:create')
            ->expectsQuestion('What is your name?', $user->name)
            ->expectsQuestion('What is your email?', $user->email)
            ->expectsQuestion('What is your password?', $user->password)
            ->assertExitCode(0)->execute();

        $userCreated = User::where('email', $user->email)->first();

        $this->assertEquals(
            [
                'name' => $user->name,
                'email' => $user->email
            ],
            [
                'name' => $userCreated->name,
                'email' => $userCreated->email,
            ]
        );
        $this->assertTrue(Hash::check($expectedPassword, $userCreated->password));
    }

    /**
     * @see CreateUser::handle()
     * @test
     */
    public function output_error_when_user_already_exists(): void
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
