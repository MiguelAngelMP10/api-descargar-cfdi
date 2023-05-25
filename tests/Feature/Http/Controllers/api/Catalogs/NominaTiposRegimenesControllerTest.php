<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposRegimenes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaTiposRegimenesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_tipos_regimenes_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-regimenes');
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

    
    public function test_nomina_tipos_regimenes_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-tipos-regimenes/search', ['filters' => [
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

    
    public function test_nomina_tipos_regimenes_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaTiposRegimenes::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-regimenes/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
