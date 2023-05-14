<?php

namespace Tests\Feature;

use App\Http\Controllers\api\v1\DownloadPackagesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\StatusCode;
use Tests\TestCase;

class DownloadPackagesTest extends TestCase
{
    use WithValidFielTrait, RefreshDatabase;

    private function mockControllerDownload(StatusCode $statusCode, string $resultContentPath = ''): void
    {
        $resultContent = ('' === $resultContentPath) ? '' : file_get_contents($resultContentPath);
        $downloadResult = new DownloadResult($statusCode, $resultContent);
        $this->partialMock(
            DownloadPackagesController::class,
            function (MockInterface $service) use ($downloadResult) {
                return $service
                    ->shouldAllowMockingProtectedMethods()
                    ->shouldReceive('download')
                    ->once()
                    ->andReturn($downloadResult);
            }
        );
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     *
     * @test
     */
    public function it_download_package(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $packageId = 'foo';
        $this->mockControllerDownload(new StatusCode(5000, ''), __DIR__.'/../_files/fake-download.zip');
        $expectedPackagePath = $this->getSatWsService()->obtainPackagePath($this->getFielRfc(), $packageId);

        $response = $this->postJson('/api/v1/download-packages', [
            'cer' => $this->getCertificate(),
            'key' => $this->getKey(),
            'password' => $this->getFielPassword(),
            'packagesIds' => [$packageId],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'messages' => [
                'El paquete foo se ha almacenado',
            ],
        ]);
        Storage::assertExists($expectedPackagePath);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     *
     * @test
     */
    public function it_capture_error_when_download_fail(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $errorMessageExpected = 'Certificado Inválido';
        // comment this line to test against SAT servers
        $this->mockControllerDownload(new StatusCode(400, $errorMessageExpected));

        $response = $this->postJson('/api/v1/download-packages', [
            'cer' => $this->getCertificate(),
            'key' => $this->getKey(),
            'password' => $this->getFielPassword(),
            'packagesIds' => ['foo'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errorMessages' => [
                "El paquete foo no se ha podido descargar: $errorMessageExpected",
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     *
     * @test
     */
    public function it_refuse_an_invalid_empty_request(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->postJson('/api/v1/download-packages', []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Petición inválida.',
            'errors' => [
                'cer' => ['The cer field is required.'],
                'key' => ['The key field is required.'],
                'password' => ['The password field is required.'],
                'packagesIds' => ['The packagesIds field is required.'],
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     *
     * @test
     */
    public function it_refuse_an_invalid_type_for_fields(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $response = $this->postJson('/api/v1/download-packages', [
            'cer' => $this->getCertificate(),
            'key' => $this->getKey(),
            'password' => $this->getFielPassword(),
            'packagesIds' => ['foo'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errorMessages' => [
                'El paquete foo no se ha podido descargar: Certificado Inválido',
            ],
            'messages' => [],
        ]);
    }
}
