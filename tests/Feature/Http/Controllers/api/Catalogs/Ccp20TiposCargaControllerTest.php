<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20TiposCarga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ccp20TiposCargaControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ccp_20_tipos_carga_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ccp-20-tipos-carga');
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

    
    public function test_ccp_20_tipos_carga_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ccp-20-tipos-carga/search', ['filters' => [
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

    
    public function test_ccp_20_tipos_carga_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ccp20TiposCarga::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ccp-20-tipos-carga/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
