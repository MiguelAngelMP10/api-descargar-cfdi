<?php

namespace Tests\Feature\Http\Controllers\Config;

use App\Models\Fiel;
use App\Models\Query;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class FielControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User|Model $user;
    protected Fiel|Model $fiel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->fiel = Fiel::factory()->create();
    }

    public function test_index_display_a_listing_of_the_resource()
    {
        $this->actingAs($this->user)
            ->get(route('config-fiel.index'))
            ->assertOk()
            ->assertInertia(fn(Assert $page) => $page
                ->component('Config/Fiel')
                ->has('fiels', 1)
                ->has('fiels.0', 5)
                ->where('fiels.0.rfc', $this->fiel->rfc)
                ->where('fiels.0.legalName', $this->fiel->legalName));
    }

    public function test_store_validate_inputs_required()
    {
        $this->actingAs($this->user);
        $this->postJson('config/fiel', [])
            ->assertStatus(422)->assertJson([
                "message" => "The cer field is required. (and 2 more errors)",
                "errors" => [
                    "cer" => [
                        "The cer field is required."
                    ],
                    "key" => [
                        "The key field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    public function test_store_validate_input_cer_key_password_is_string()
    {
        $this->actingAs($this->user);
        $this->postJson('config/fiel', ['cer' => 123, 'key' => 123, 'password' => 123])->assertExactJson([
            "message" => "The cer must be a string. (and 2 more errors)",
            "errors" => [
                "cer" => [
                    "The cer must be a string."
                ],
                "key" => [
                    "The key must be a string."
                ],
                "password" => [
                    "The password must be a string."
                ]
            ]
        ])->assertStatus(422);
    }

    public function test_store_full()
    {
        $pathFakeFiel = base_path('tests/_files/fake-fiel/');
        $certificatePath = $pathFakeFiel . 'EKU9003173C9-pem.cer';
        $privateKeyPath = $pathFakeFiel . 'EKU9003173C9-pem.key';
        $passPhrase = trim(file_get_contents($pathFakeFiel . 'EKU9003173C9-password.txt'));
        $cer = file_get_contents($certificatePath);
        $key = file_get_contents($privateKeyPath);
        $this->actingAs($this->user);
        $this->postJson('config/fiel', ['cer' => $cer, 'key' => $key, 'password' => $passPhrase])
            ->assertSessionHas('success', 'The Fiel was added correctly');

        $this->assertDatabaseCount(Fiel::class, '2');
    }
}
