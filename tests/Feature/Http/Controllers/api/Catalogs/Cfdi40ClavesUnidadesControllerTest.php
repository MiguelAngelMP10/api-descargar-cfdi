<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40ClavesUnidades;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Cfdi40ClavesUnidadesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cfdi_40_claves_unidades_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cfdi-40-claves-unidades');
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

    
    public function test_cfdi_40_claves_unidades_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cfdi-40-claves-unidades/search', ['filters' => [
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

    
    public function test_cfdi_40_claves_unidades_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Cfdi40ClavesUnidades::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cfdi-40-claves-unidades/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
