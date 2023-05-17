<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Fiel;
use App\Models\Package;
use App\Models\Query;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DownloadPackagesControllerTest extends TestCase
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
        Package::factory(1)->create();
    }

    public function test_download_packages_success_ui()
    {
        $query = Query::find(1);
        $query->rfc = 'EKU9003173C9';
        $query->save();
        $packageId = $query->packeges()->first()->packageId;
        $this->actingAs($this->user)
            ->get(route('download.packages', $query->id))
            ->assertStatus(302)
            ->assertSessionHas('success', 'Se almaceno el paquete con id: ' . $packageId . '<br>');
    }

    public function test_download_packages_error_ui()
    {
        $query = Query::find(1);
        $this->actingAs($this->user)
            ->get(route('download.packages', $query->id))
            ->assertSessionHas('error', 'Attempt to read property "cer" on null');
    }
}
