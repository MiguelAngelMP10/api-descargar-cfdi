<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Fiel;
use App\Models\Query;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class QueryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User|Model $user;

    protected Fiel|Model $fiel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->fiel = Fiel::factory()->create();
        Query::factory(10)->create();
    }

    public function test_index_display_a_listing_of_the_resource()
    {
        $this->actingAs($this->user)
            ->get(route('queries.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Queries/Index')
                ->has('queries')
                ->has('search')
                ->has('queries.links')
                ->has('queries.data', 10));
    }

    public function test_show_the_form_for_creating_a_new_resource()
    {
        $this->actingAs($this->user)
            ->get(route('queries.create'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Queries/Create')
                ->where('errors', [])
                ->has('endpoint', 2)
                ->has('downloadType', 2)
                ->has('requestType', 2)
                ->has('documentType', 6)
                ->has('complementoCfdi', 38)
                ->has('documentStatus', 3));
    }

    public function test_show_query_display_the_specified_resource()
    {
        $this->actingAs($this->user)
            ->get(route('queries.show', 1))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Queries/Show')
                ->has('auth.user', 10)
                ->has('query', 22)
                ->where('query.user_id', $this->user->id));
    }

    public function test_store_validate_inputs_required()
    {
        $this->actingAs($this->user);
        $this->postJson(route('queries.store'))
            ->assertStatus(422)->assertJson([
                'message' => 'The rfc field is required.',
                'errors' => [
                    'rfc' => [
                        'The rfc field is required.',
                    ],
                ],
            ]);
    }

    public function test_store_try_create_new_query()
    {
        $this->actingAs($this->user);
        $this->postJson(route('queries.store'), [
            'rfc' => $this->fiel->rfc,
            'endPoint' => ['cfdi'],
            'downloadType' => ['issued', 'received'],
            'requestType' => ['metadata'],
        ])->assertSessionHas('success', 'Queries created successfully <br>RequestId: <br>Queries created successfully <br>RequestId: <br>');
        $this->assertDatabaseCount(Query::class, 12);
    }
}
