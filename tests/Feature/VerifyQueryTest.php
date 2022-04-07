<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VerifyQueryTest extends TestCase
{
    use WithValidFielTrait, RefreshDatabase;

    public function test_it_refuse_an_invalid_empty_request(): void
    {
        $this->setUpValidFiel();
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/verify-query', []);

        $response->dd();
    }
}
