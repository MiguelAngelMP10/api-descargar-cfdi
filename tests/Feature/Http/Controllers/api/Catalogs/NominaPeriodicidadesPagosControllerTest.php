<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaPeriodicidadesPagos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaPeriodicidadesPagosControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_periodicidades_pagos_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-periodicidades-pagos');
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

    
    public function test_nomina_periodicidades_pagos_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-periodicidades-pagos/search', ['filters' => [
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

    
    public function test_nomina_periodicidades_pagos_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaPeriodicidadesPagos::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-periodicidades-pagos/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
