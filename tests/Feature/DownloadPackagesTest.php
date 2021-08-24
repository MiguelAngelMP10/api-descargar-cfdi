<?php

namespace Tests\Feature;

use App\Helpers\SatWsService;
use App\Http\Controllers\api\v1\DownloadPackagesController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\StatusCode;
use Tests\TestCase;

class DownloadPackagesTest extends TestCase
{
    /**
     * @return array ['password' => 'privateKeyPassword', 'rfc' => 'rfc']
     */
    private function prepareFielForEkuFiel(): array
    {
        $certificatePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.cer';
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';
        $service = new SatWsService();
        $rfc = 'EKU9003173C9';
        Storage::put($service->obtainCertificatePath($rfc), file_get_contents($certificatePath));
        Storage::put($service->obtainPrivateKeyPath($rfc), file_get_contents($privateKeyPath));
        return ['password' => file_get_contents($passPhrasePath), 'rfc' => $rfc];
    }

    private function mockGoodDownload()
    {
        $fakeDownload = __DIR__ . '/../_files/fake-download.zip';
        $statusCode = new StatusCode(5000, '');
        $downloadResult = new DownloadResult($statusCode, file_get_contents($fakeDownload));
        $this->partialMock(DownloadPackagesController::class, function (MockInterface $service) use ($downloadResult) {
            $service->shouldAllowMockingProtectedMethods()
                ->shouldReceive('download')->once()->andReturn($downloadResult);
        });
    }

    private function mockBadDownload($message): void
    {
        $statusCode = new StatusCode(400, $message);
        $downloadResult = new DownloadResult($statusCode, '');
        $this->partialMock(DownloadPackagesController::class, function (MockInterface $service) use ($downloadResult) {
            $service->shouldAllowMockingProtectedMethods()
                ->shouldReceive('download')->once()->andReturn($downloadResult);
        });
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     * @test
     */
    public function it_download_package()
    {
        Storage::fake('local');
        $fielData = $this->prepareFielForEkuFiel();
        $rfc = $fielData['rfc'];
        $this->mockGoodDownload();
        $packageId = 'foo';
        $response = $this->postJson('/api/v1/download-packages', [
            'RFC' => $rfc,
            'password' => $fielData['password'],
            'retenciones' => false,
            'packagesIds' => [$packageId],
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'messages' => [
                'El paquete foo se ha almacenado',
            ],
        ]);
        Storage::assertExists("datos/${rfc}/packages/${packageId}.zip");
    }

    /**
     * @see DownloadPackagesController::downloadPackages()
     * @test
     */
    public function it_download_package_invalid_fiel()
    {
        Storage::fake('local');
        $fielData = $this->prepareFielForEkuFiel();
        $errorMessageExpected = 'Certificado Inválido';
        //coment this line for real test
        $this->mockBadDownload($errorMessageExpected);
        $response = $this->postJson('/api/v1/download-packages', [
            'RFC' => $fielData['rfc'],
            'password' => $fielData['password'],
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
        $file = UploadedFile::fake()->create('image.png');
        $response = $this->postJson('/api/v1/download-packages', [
            'RFC' => $file,
            'password' => $file,
            'retenciones' => $file,
            'packagesIds' => $file,
        ]);
        $response->assertStatus(422)->assertJson([
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
        $response = $this->post('/api/v1/download-packages', [
            'RFC' => 'invalid-rfc',
            'password' => 'password',
            'retenciones' => false,
            'packageIds' => ['foo', 'bar'],
        ]);
        $response->assertStatus(422)->assertJson([
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
        $response = $this->post('/api/v1/download-packages', [
            'RFC' => 'AAA010101AAA',
            'password' => 'password',
            'retenciones' => false,
            'packagesIds' => ['foo', 'bar'],
        ]);
        $response->assertStatus(422)->assertJson([
            'message' => 'Petición inválida.',
            'errors' => [
                'RFC' => ['Unable to create the SAT web service.'],
            ],
        ]);
    }
}
