<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceUnidadesMedida;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CceUnidadesMedidaControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cce_unidades_medida_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cce-unidades-medida');
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

    
    public function test_cce_unidades_medida_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cce-unidades-medida/search', ['filters' => [
            [
                'field' => 'id',
                'operator' => 'like',
                'value' => '%abc%'
            ]
        ]]);
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

    
    public function test_cce_unidades_medida_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CceUnidadesMedida::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cce-unidades-medida/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
