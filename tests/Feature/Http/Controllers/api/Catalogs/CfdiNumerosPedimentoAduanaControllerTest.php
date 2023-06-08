<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CfdiNumerosPedimentoAduana;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CfdiNumerosPedimentoAduanaControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cfdi_numeros_pedimento_aduana_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cfdi-numeros-pedimento-aduana');
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

    
    public function test_cfdi_numeros_pedimento_aduana_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cfdi-numeros-pedimento-aduana/search', ['filters' => [
            [
                'field' => 'aduana',
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

    
    public function test_cfdi_numeros_pedimento_aduana_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CfdiNumerosPedimentoAduana::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cfdi-numeros-pedimento-aduana/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
