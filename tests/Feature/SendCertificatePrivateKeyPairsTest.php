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
    private Filesystem $disk;

    private string $expectedCertificatePath;

    private string $expectedPrivateKeyPath;

    private function makeUploadFile(string $path): UploadedFile
    {
        return new UploadedFile($path, basename($path), null, null, true);
    }

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
            'cer' => $this->makeUploadFile($certificatePath),
            'key' =>  $this->makeUploadFile($privateKeyPath),
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
    public function it_refuse_an_invalid_empty_request(): void
    {
        $response = $this->post('/api/v1/send-cer-key', []);
        $response->assertStatus(422)->assertJson([
            'message' => 'Los datos enviados de certificado, llave privada o contraseña son inválidos.',
            'errors' => [
                'password' => ['The password field is required.'],
                'key' => ['The key field is required.'],
                'cer' => ['The cer field is required.']
            ]
        ]);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_sending_string_instead_of_file(): void
    {
        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => 'foo',
            'key' => 'bar',
            'password' => 'pwd',
        ]);
        $response->assertStatus(422)->assertJson([
            'errors' =>
            [
                'cer' => ['The certificate is not a file.'],
                'key' => ['The private key is not a file.']
            ],
        ]);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_an_invalid_file_mimetype(): void
    {

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => UploadedFile::fake()->create('image.png'),
            'key' =>  UploadedFile::fake()->create('image.jpg'),
            'password' => 'pwd',
        ]);
        $response->assertStatus(422)->assertJson([
            'message' => 'Los datos enviados de certificado, llave privada o contraseña son inválidos.',
            'errors' =>
            [
                'cer' => ['The certificate file has invalid type.'],
                'key' => ['The private key file has invalid type.']
            ],
        ]);
    }

    /**
     * @see SendCerKeyController::sendCerKey()
     * @test
     */
    public function it_refuse_an_invalid_certificate(): void
    {
        $certificatePath = __DIR__ . '/../_files/plain-text.txt';
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => $this->makeUploadFile($certificatePath),
            'key' =>  $this->makeUploadFile($privateKeyPath),
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
        $privateKeyPath = __DIR__ . '/../_files/plain-text.txt';
        $passPhrasePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt';

        $response = $this->post('/api/v1/send-cer-key', [
            'cer' => $this->makeUploadFile($certificatePath),
            'key' =>  $this->makeUploadFile($privateKeyPath),
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
            'cer' => $this->makeUploadFile($certificatePath),
            'key' =>  $this->makeUploadFile($privateKeyPath),
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
            'cer' => $this->makeUploadFile($certificatePath),
            'key' =>  $this->makeUploadFile($privateKeyPath),
            'password' => trim(file_get_contents($passPhrasePath)),
        ]);
        $response->assertStatus(422);
        $response->assertJson(["message" => "Certificado, llave privada o contraseña inválida"]);

        $this->disk->assertMissing($this->expectedCertificatePath);
        $this->disk->assertMissing($this->expectedPrivateKeyPath);
    }
}
