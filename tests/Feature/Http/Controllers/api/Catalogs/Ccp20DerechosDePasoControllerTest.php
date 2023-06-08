<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ccp20DerechosDePaso;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ccp20DerechosDePasoControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ccp_20_derechos_de_paso_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ccp-20-derechos-de-paso');
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

    
    public function test_ccp_20_derechos_de_paso_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ccp-20-derechos-de-paso/search', ['filters' => [
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

    
    public function test_ccp_20_derechos_de_paso_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ccp20DerechosDePaso::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ccp-20-derechos-de-paso/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
