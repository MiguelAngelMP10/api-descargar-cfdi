<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function sanctumAuthenticate(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }
}
