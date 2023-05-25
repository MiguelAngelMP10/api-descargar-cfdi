<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaRiesgosPuestos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaRiesgosPuestosControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_riesgos_puestos_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-riesgos-puestos');
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

    
    public function test_nomina_riesgos_puestos_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-riesgos-puestos/search', ['filters' => [
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

    
    public function test_nomina_riesgos_puestos_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaRiesgosPuestos::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-riesgos-puestos/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
