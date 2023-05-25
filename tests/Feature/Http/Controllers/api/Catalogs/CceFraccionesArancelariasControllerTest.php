<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceFraccionesArancelarias;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CceFraccionesArancelariasControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cce_fracciones_arancelarias_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cce-fracciones-arancelarias');
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

    
    public function test_cce_fracciones_arancelarias_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cce-fracciones-arancelarias/search', ['filters' => [
            [
                'field' => 'fraccion',
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

    
    public function test_cce_fracciones_arancelarias_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CceFraccionesArancelarias::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cce-fracciones-arancelarias/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
