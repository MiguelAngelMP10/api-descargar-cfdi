<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20TiposPagoRetencion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ret20TiposPagoRetencionControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ret_20_tipos_pago_retencion_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ret-20-tipos-pago-retencion');
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

    
    public function test_ret_20_tipos_pago_retencion_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ret-20-tipos-pago-retencion/search', ['filters' => [
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

    
    public function test_ret_20_tipos_pago_retencion_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ret20TiposPagoRetencion::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ret-20-tipos-pago-retencion/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
