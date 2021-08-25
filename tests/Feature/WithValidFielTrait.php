<?php

declare(strict_types=1);

/**
 *
 */

namespace Tests\Feature;


use App\Helpers\SatWsService;
use Illuminate\Support\Facades\Storage;

trait WithValidFielTrait
{
    private string $fielRfc;

    private string $fielPassword;

    private SatWsService $satWsService;

    private function setUpValidFiel(): void
    {
        $satWsService = new SatWsService();
        $rfc = 'EKU9003173C9';
        $certificatePath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.cer';
        $privateKeyPath = __DIR__ . '/../_files/fake-fiel/EKU9003173C9.key';
        $passPhrase = trim(file_get_contents(__DIR__ . '/../_files/fake-fiel/EKU9003173C9-password.txt'));

        Storage::fake('local');
        Storage::put($satWsService->obtainCertificatePath($rfc), file_get_contents($certificatePath));
        Storage::put($satWsService->obtainPrivateKeyPath($rfc), file_get_contents($privateKeyPath));

        $this->fielRfc = $rfc;
        $this->fielPassword = $passPhrase;
        $this->satWsService = $satWsService;
    }

    protected function getFielRfc(): string
    {
        return $this->fielRfc;
    }

    protected function getFielPassword(): string
    {
        return $this->fielPassword;
    }

    protected function getSatWsService(): SatWsService
    {
        return $this->satWsService;
    }
}
