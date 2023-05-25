<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\NominaTiposNominas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NominaTiposNominasControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_nomina_tipos_nominas_index(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-nominas');
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

    
    public function test_nomina_tipos_nominas_search(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/catalogs/nomina-tipos-nominas/search', ['filters' => [
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

    
    public function test_nomina_tipos_nominas_show(): void
    {
        $this->sanctumAuthenticate();
        $model = NominaTiposNominas::first();
        $keyName = $model->getKeyName();
        $response = $this->get('/api/v1/catalogs/nomina-tipos-nominas/'.$model->{$keyName});
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => []
        ]);
    }
}
