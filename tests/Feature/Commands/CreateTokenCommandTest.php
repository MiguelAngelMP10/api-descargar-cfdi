<?php

namespace Tests\Feature\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTokenCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @see CreateToken::handle()
     * @test
     */
    public function create_token_for_existing_user(): void
    {
        $user = User::factory()->create();

        $this->artisan("token:create $user->id --name=testToken")
            ->assertExitCode(0)->execute();
        $this->assertCount(1, $user->tokens->toArray());
    }

    /**
     * @see CreateToken::handle()
     * @test
     */
    public function refuse_creating_token_for_non_existing_user(): void
    {
        $this->artisan("token:create 123123123 --name=testToken")
            ->assertExitCode(1)->execute();
    }
}
