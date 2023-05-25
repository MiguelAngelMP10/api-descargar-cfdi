<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaOrigenesRecursos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaOrigenesRecursosControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_origenes_recursos_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-origenes-recursos');
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

    
    public function test_nomina_origenes_recursos_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-origenes-recursos/search', ['filters' => [
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

    
    public function test_nomina_origenes_recursos_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaOrigenesRecursos::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-origenes-recursos/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
