<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceMotivosTraslado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CceMotivosTrasladoControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cce_motivos_traslado_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cce-motivos-traslado');
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

    
    public function test_cce_motivos_traslado_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cce-motivos-traslado/search', ['filters' => [
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

    
    public function test_cce_motivos_traslado_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CceMotivosTraslado::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cce-motivos-traslado/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
