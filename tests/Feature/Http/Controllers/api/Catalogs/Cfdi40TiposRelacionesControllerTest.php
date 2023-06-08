<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Cfdi40TiposRelaciones;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Cfdi40TiposRelacionesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cfdi_40_tipos_relaciones_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cfdi-40-tipos-relaciones');
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

    
    public function test_cfdi_40_tipos_relaciones_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cfdi-40-tipos-relaciones/search', ['filters' => [
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

    
    public function test_cfdi_40_tipos_relaciones_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Cfdi40TiposRelaciones::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cfdi-40-tipos-relaciones/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
