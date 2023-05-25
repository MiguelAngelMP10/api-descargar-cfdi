<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\CceClavesPedimentos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CceClavesPedimentosControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_cce_claves_pedimentos_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/cce-claves-pedimentos');
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

    
    public function test_cce_claves_pedimentos_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/cce-claves-pedimentos/search', ['filters' => [
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

    
    public function test_cce_claves_pedimentos_show(): void
    {
        $this->sanctumAuthenticate();
        $model = CceClavesPedimentos::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/cce-claves-pedimentos/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
