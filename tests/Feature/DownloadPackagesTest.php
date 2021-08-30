<?php

namespace Tests\Feature;

use App\Http\Controllers\api\v1\DownloadPackagesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
     * @test
     */
    public function it_download_package(): void
    {
        $this->sanctumAuthenticate();
        $this->setUpValidFiel();
        $packageId = 'foo';
        $this->mockControllerDownload(new StatusCode(5000, ''), __DIR__ . '/../_files/fake-download.zip');
        $expectedPackagePath = $this->getSatWsService()->obtainPackagePath($this->getFielRfc(), $packageId);

        $response = $this->postJson('/api/v1/download-packages', [
            'RFC' => $this->getFielRfc(),
            'password' => $this->getFielPassword(),
            'retenciones' => false,
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
            'RFC' => $this->getFielRfc(),
            'password' => $this->getFielPassword(),
            'retenciones' => false,
            'packagesIds' => ['foo'],
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'errorMessages' => [
                "El paquete foo no se ha podido descargar: $errorMessageExpected"
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
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
                'RFC' => ['The rfc field is required.'],
                'password' => ['The password field is required.'],
                'retenciones' => ['The retenciones field is required.'],
                'packagesIds' => ['The packages ids field is required.'],
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     * @test
     */
    public function it_refuse_an_invalid_type_for_fields(): void
    {
        $this->sanctumAuthenticate();
        $file = UploadedFile::fake()->create('image.png');
        $response = $this->postJson('/api/v1/download-packages', [
            'RFC' => $file,
            'password' => $file,
            'retenciones' => $file,
            'packagesIds' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Petición inválida.',
            'errors' => [
                'RFC' => ['The rfc must be a string.'],
                'password' => ['The password must be a string.'],
                'retenciones' => ['The retenciones field must be true or false.'],
                'packagesIds' => ['The packages ids must be an array.'],
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     * @test
     */
    public function it_refuse_an_invalid_rfc(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/download-packages', [
            'RFC' => 'invalid-rfc',
            'password' => 'password',
            'retenciones' => false,
            'packageIds' => ['foo', 'bar'],
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Petición inválida.',
            'errors' => [
                'RFC' => ['The RFC field not appears to be valid.'],
            ],
        ]);
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     * @test
     */
    public function it_refuse_with_non_existing_fiel(): void
    {
        $this->sanctumAuthenticate();
        $response = $this->post('/api/v1/download-packages', [
            'RFC' => 'AAA010101AAA',
            'password' => 'password',
            'retenciones' => false,
            'packagesIds' => ['foo', 'bar'],
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Petición inválida.',
            'errors' => [
                'RFC' => ['Unable to create the SAT web service.'],
            ],
        ]);
    }
}
