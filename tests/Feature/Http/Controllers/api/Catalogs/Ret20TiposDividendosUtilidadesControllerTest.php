<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\Ret20TiposDividendosUtilidades;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Ret20TiposDividendosUtilidadesControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_ret_20_tipos_dividendos_utilidad_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/ret-20-tipos-dividendos-utilidad');
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

    
    public function test_ret_20_tipos_dividendos_utilidad_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/ret-20-tipos-dividendos-utilidad/search', ['filters' => [
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

    
    public function test_ret_20_tipos_dividendos_utilidad_show(): void
    {
        $this->sanctumAuthenticate();
        $model = Ret20TiposDividendosUtilidades::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/ret-20-tipos-dividendos-utilidad/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
