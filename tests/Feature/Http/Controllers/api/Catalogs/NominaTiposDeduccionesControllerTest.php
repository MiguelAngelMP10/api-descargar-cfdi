<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposDeducciones;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaTiposDeduccionesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_tipos_deducciones_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-deducciones');
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

    
    public function test_nomina_tipos_deducciones_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-tipos-deducciones/search', ['filters' => [
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

    
    public function test_nomina_tipos_deducciones_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaTiposDeducciones::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-deducciones/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
