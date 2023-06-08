<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposCarro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ccp20TiposCarroControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ccp_20_tipos_carro_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ccp-20-tipos-carro');
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

    
    public function test_ccp_20_tipos_carro_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ccp-20-tipos-carro/search', ['filters' => [
            [
                'field' => 'id',
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

    
    public function test_ccp_20_tipos_carro_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ccp20TiposCarro::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ccp-20-tipos-carro/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
