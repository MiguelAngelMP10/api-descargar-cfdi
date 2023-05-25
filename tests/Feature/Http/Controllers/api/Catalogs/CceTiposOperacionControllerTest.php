<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceTiposOperacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CceTiposOperacionControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cce_tipos_operacion_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cce-tipos-operacion');
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

    
    public function test_cce_tipos_operacion_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cce-tipos-operacion/search', ['filters' => [
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

    
    public function test_cce_tipos_operacion_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CceTiposOperacion::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cce-tipos-operacion/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
