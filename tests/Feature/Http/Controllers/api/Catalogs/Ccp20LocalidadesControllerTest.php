<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20Localidades;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ccp20LocalidadesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ccp_20_localidades_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ccp-20-localidades');
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

    
    public function test_ccp_20_localidades_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ccp-20-localidades/search', ['filters' => [
            [
                'field' => 'localidad',
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
