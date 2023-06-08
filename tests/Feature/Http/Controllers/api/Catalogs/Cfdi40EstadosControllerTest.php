<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40Estados;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Cfdi40EstadosControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cfdi_40_estados_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cfdi-40-estados');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
            ]
        ]);
    }

    
    public function test_cfdi_40_estados_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cfdi-40-estados/search', ['filters' => [
            [
                'field' => 'estado',
                'operator' => 'like',
                'value' => '%abc%'
            ]
        ]]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [],
            'links' => [],
            'meta' => []
        ]);
    }

    
}
