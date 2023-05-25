<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiReglasTasaCuota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CfdiReglasTasaCuotaControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cfdi_reglas_tasa_cuota_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cfdi-reglas-tasa-cuota');
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

    
    public function test_cfdi_reglas_tasa_cuota_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cfdi-reglas-tasa-cuota/search', ['filters' => [
            [
                'field' => 'tipo',
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

    
    public function test_cfdi_reglas_tasa_cuota_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CfdiReglasTasaCuota::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cfdi-reglas-tasa-cuota/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
