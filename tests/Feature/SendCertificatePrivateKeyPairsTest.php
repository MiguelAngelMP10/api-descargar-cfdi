<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\SatWsService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

final class SendCertificatePrivateKeyPairsTest extends TestCase
{
    /** @var Filesystem */
    private $disk;

    /** @var string */
    private $expectedCertificatePath;

    /** @var string */
    private $expectedPrivateKeyPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->disk = Storage::fake('local');

        $satWsService = new SatWsService();
        $this->expectedCertificatePath = $satWsService->obtainCertificatePath('EKU9003173C9');
        $this->expectedPrivateKeyPath = $satWsService->obtainPrivateKeyPath('EKU9003173C9');
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_receive_valid_certificate_and_private_key(): void
    {
        $certificatePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.cer';
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => new UploadedFile($certificatePath, basename($certificatePath)),
            'key' => new UploadedFile($privateKeyPath, basename($privateKeyPath)),
            'password' => trim(file_get_contents($passPhrasePath)),
        ]);

        $response->assertStatus(200);
        $this->assertStringContainsString('EKU9003173C9.cer', $response->json('pathCer'));
        $this->assertStringContainsString('EKU9003173C9.key', $response->json('pathKey'));

        $this->disk->assertExists($this->expectedCertificatePath);
        $this->disk->assertExists($this->expectedPrivateKeyPath);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_an_invalid_certificate(): void
    {
        $certificatePath = __FILE__;
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => new UploadedFile($certificatePath, basename($certificatePath)),
            'key' => new UploadedFile($privateKeyPath, basename($privateKeyPath)),
            'password' => trim(file_get_contents($passPhrasePath)),
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "Certificado, llave privada o contraseña inválida"]);

        $this->disk->assertMissing($this->expectedCertificatePath);
        $this->disk->assertMissing($this->expectedPrivateKeyPath);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_an_invalid_privatekey(): void
    {
        $certificatePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.cer';
        $privateKeyPath = __FILE__;
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => new UploadedFile($certificatePath, basename($certificatePath)),
            'key' => new UploadedFile($privateKeyPath, basename($privateKeyPath)),
            'password' => trim(file_get_contents($passPhrasePath)),
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "Certificado, llave privada o contraseña inválida"]);

        $this->disk->assertMissing($this->expectedCertificatePath);
        $this->disk->assertMissing($this->expectedPrivateKeyPath);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_an_invalid_password(): void
    {
        $certificatePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.cer';
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => new UploadedFile($certificatePath, basename($certificatePath)),
            'key' => new UploadedFile($privateKeyPath, basename($privateKeyPath)),
            'password' => trim(file_get_contents($passPhrasePath)) . '-invalid-password',
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "Certificado, llave privada o contraseña inválida"]);

        $this->disk->assertMissing($this->expectedCertificatePath);
        $this->disk->assertMissing($this->expectedPrivateKeyPath);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuses_valid_csd(): void
    {
        $certificatePath = __DIR__ . '/../_files/fake-csd/EKU9003173C9.cer';
        $privateKeyPath = __DIR__ . '/../_files/fake-csd/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-csd/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => new UploadedFile($certificatePath, basename($certificatePath)),
            'key' => new UploadedFile($privateKeyPath, basename($privateKeyPath)),
            'password' => trim(file_get_contents($passPhrasePath)),
        ]);

        $response->assertStatus(422);
        $response->assertJson(["message" => "Certificado, llave privada o contraseña inválida"]);

        $this->disk->assertMissing($this->expectedCertificatePath);
        $this->disk->assertMissing($this->expectedPrivateKeyPath);
    }
}
