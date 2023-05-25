<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposPercepciones;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaTiposPercepcionesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_tipos_percepciones_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-percepciones');
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

    
    public function test_nomina_tipos_percepciones_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-tipos-percepciones/search', ['filters' => [
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

    
    public function test_nomina_tipos_percepciones_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaTiposPercepciones::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-percepciones/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
