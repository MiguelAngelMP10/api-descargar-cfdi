<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\PagosTiposCadenaPago;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagosTiposCadenaPagoControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_pagos_tipos_cadena_pago_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/pagos-tipos-cadena-pago');
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

    
    public function test_pagos_tipos_cadena_pago_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/pagos-tipos-cadena-pago/search', ['filters' => [
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

    
    public function test_pagos_tipos_cadena_pago_show(): void
    {
        $this->sanctumAuthenticate();
        $model = PagosTiposCadenaPago::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/pagos-tipos-cadena-pago/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
