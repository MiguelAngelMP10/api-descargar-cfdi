<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CfdiToJsonControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_component_cfdi_to_json_index()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('cfdi.to.json'))
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('CfdiToJson/Index'));
    }
}
