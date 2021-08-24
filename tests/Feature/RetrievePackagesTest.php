<?php
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\SatWsService;
use App\Http\Controllers\api\v1\PackagesController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class RetrievePackagesTest extends TestCase
{
    use WithFaker;

    private SatWsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new SatWsService();
    }

    private function createPackageId(): string
    {
        return $this->faker->uuid;
    }

    /**
     * @return array<string, string>
     */
    private function createPackages(string $rfc, int $count): array
    {
        $packages = [];
        for ($i = 0; $i < $count; $i++) {
            $packageId = $this->createPackageId();
            $packagePath = $this->service->obtainPackagePath($rfc, $packageId);
            Storage::put($packagePath, $this->faker->text);
            $packages[$packageId] = $packagePath;
        }
        return $packages;
    }

    /**
     * @see PackagesController::index()
     * @test
     */
    public function list_of_empty_packages(): void
    {
        $rfc = 'AAAA010101AAA';
        $response = $this->getJson("/api/v1/$rfc/packages");
        $response->assertStatus(200);
        $response->assertJson(['rfc' => $rfc], true);
        $response->assertJsonCount(0, 'packages');
    }

    /**
     * @see PackagesController::index()
     * @test
     */
    public function list_of_packages(): void
    {
        Storage::fake('local');

        $rfc = 'AAAA010101AAA';
        $packageIds = array_keys($this->createPackages($rfc, 3));
        sort($packageIds);

        $response = $this->getJson("/api/v1/$rfc/packages");

        $response->assertStatus(200);
        $response->assertJson(['rfc' => $rfc, 'packages' => $packageIds]);
        $response->assertJsonCount(3, 'packages');
    }

    /**
     * @see PackagesController::index()
     * @test
     */
    public function list_not_found_on_invalid_rfc(): void
    {
        $invalidRfc = 'invalid-rfc';

        $response = $this->getJson("/api/v1/$invalidRfc/packages");

        $response->assertStatus(404);
        $response->assertJson(['message' => "Invalid RFC value $invalidRfc."]);
    }

    /**
     * @see PackagesController::download()
     * @test
     */
    public function download_a_package(): void
    {
        Storage::fake('local');

        $rfc = 'AAAA010101AAA';
        $packages = $this->createPackages($rfc, 1);
        $packageId = array_key_first($packages);
        $packagePath = $packages[$packageId];

        $response = $this->get("/api/v1/$rfc/packages/$packageId");

        $response->assertStatus(200);
        $this->assertEquals(Storage::get($packagePath), $response->streamedContent());
    }

    /**
     * @see PackagesController::download()
     * @test
     */
    public function download_not_found_using_invalid_rfc(): void
    {
        $invalidRfc = 'invalid-rfc';
        $packageId = $this->createPackageId();

        $response = $this->getJson("/api/v1/$invalidRfc/packages/$packageId");

        $response->assertStatus(404);
        $response->assertJson(['message' => "Invalid RFC value $invalidRfc."]);
    }

    /**
     * @see PackagesController::download()
     * @test
     */
    public function download_not_found_on_non_existent_package(): void
    {
        Storage::fake('local');

        $rfc = 'AAAA010101AAA';
        $packageId = $this->createPackageId();

        $response = $this->getJson("/api/v1/$rfc/packages/$packageId");

        $response->assertStatus(404);
        $response->assertJson(['message' => "Package $rfc/$packageId not found."]);
    }

    /**
     * @see PackagesController::delete()
     * @test
     */
    public function delete_ok_when_package_exists(): void
    {
        Storage::fake('local');

        $rfc = 'AAAA010101AAA';
        $packages = $this->createPackages($rfc, 1);
        $packageId = array_key_first($packages);
        $packagePath = $packages[$packageId];

        $response = $this->deleteJson("/api/v1/$rfc/packages/$packageId");

        $response->assertStatus(204);
        Storage::assertMissing($packagePath);
    }

    /**
     * @see PackagesController::delete()
     * @test
     */
    public function delete_ok_when_package_does_not_exists(): void
    {
        $rfc = 'AAAA010101AAA';
        $packageId = $this->createPackageId();

        $response = $this->deleteJson("/api/v1/$rfc/packages/$packageId");

        $response->assertStatus(204);
    }

    /**
     * @see PackagesController::delete()
     * @test
     */
    public function delete_not_found_on_invalid_rfc(): void
    {
        $invalidRfc = 'invalid-rfc';
        $packageId = $this->createPackageId();

        $response = $this->deleteJson("/api/v1/$invalidRfc/packages/$packageId");

        $response->assertStatus(404);
        $response->assertJson(['message' => "Invalid RFC value $invalidRfc."]);
    }
}
