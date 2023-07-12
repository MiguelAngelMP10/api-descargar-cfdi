<?php

namespace Tests\Feature\Http\Controllers\api\v1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplementsCfdiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_content_and_status(): void
    {
        $this->sanctumAuthenticate();
        $this->get('api/v1/complements/cfdi')
            ->assertStatus(200)
            ->assertJsonStructure(['data' => []]);
    }
}
