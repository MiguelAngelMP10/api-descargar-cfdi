<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Http\Controllers\api\Catalogs\CceClavesPedimentosController;
use App\Models\Catalogs\CceClavesPedimentos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class CceClavesPedimentosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_cce_claves_pedimentos_index(): void
    {
        $this->sanctumAuthenticate();
        Http::fake([
            'api.com/api/v1/catalogs/cce-claves-pedimentos' => Http::response([
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
                ]]),
        ]);

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
        Http::fake([
            'api.com/api/v1/catalogs/cce-claves-pedimentos/search' => Http::response([
                'data' => [],
                'links' => [],
                'meta' => []
            ]),
        ]);
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
        Http::fake([
            'api.com/api/v1/catalogs/cce-claves-pedimentos/*' => Http::response([
                'data' => [],
            ]),
        ]);
        $response = $this->get('/api/v1/catalogs/cce-claves-pedimentos/a');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
