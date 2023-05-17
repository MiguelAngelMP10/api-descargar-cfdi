<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Helpers\SatWsService;

trait WithValidFielTrait
{
    private string $certificate;

    private string $key;

    private string $fielPassword;

    private SatWsService $satWsService;

    private function setUpValidFiel(): void
    {
        $satWsService = new SatWsService();
        $certificatePath = __DIR__.'/../_files/fake-fiel/EKU9003173C9-pem.cer';
        $privateKeyPath = __DIR__.'/../_files/fake-fiel/EKU9003173C9-pem.key';
        $passPhrase = trim(file_get_contents(__DIR__.'/../_files/fake-fiel/EKU9003173C9-password.txt'));

        $this->certificate = file_get_contents($certificatePath);
        $this->key = file_get_contents($privateKeyPath);

        $this->fielPassword = $passPhrase;
        $this->satWsService = $satWsService;
    }

    protected function getFielRfc(): string
    {
        $fiel = $this->satWsService->createFiel($this->certificate, $this->key, $this->fielPassword);

        return $fiel->getRfc();
    }

    protected function getCertificate(): string
    {
        return $this->certificate;
    }

    protected function getKey(): string
    {
        return $this->key;
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
