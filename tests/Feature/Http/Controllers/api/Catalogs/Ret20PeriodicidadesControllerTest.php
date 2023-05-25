<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20Periodicidades;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ret20PeriodicidadesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ret_20_periodicidades_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ret-20-periodicidades');
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

    
    public function test_ret_20_periodicidades_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ret-20-periodicidades/search', ['filters' => [
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

    
    public function test_ret_20_periodicidades_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ret20Periodicidades::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ret-20-periodicidades/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
