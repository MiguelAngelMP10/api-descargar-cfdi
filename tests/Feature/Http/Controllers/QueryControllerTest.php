<?php

namespace Tests\Feature\Http\Controllers;

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Query::factory(10)->create();
    }

    public function test_index_display_a_listing_of_the_resource()
    {
        $this->actingAs($this->user)
            ->get(route('queries.index'))
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Queries/Index')
                ->has('queries')
                ->has('search')
                ->has('queries.links')
                ->has('queries.data', 10)
            );
    }

    public function test_show_the_form_for_creating_a_new_resource()
    {
        $this->actingAs($this->user)
            ->get(route('queries.create'))
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Queries/Create')
                ->has('endpoint', 2)
                ->has('downloadType', 2)
                ->has('requestType', 2)
                ->has('documentType', 6)
                ->has('complementoCfdi', 35)
                ->has('documentStatus', 2)
            );
    }

    public function test_store_a_newly_created_resource_in_storage()
    {

    }

    public function test_show_query_display_the_specified_resource()
    {

    }
}
