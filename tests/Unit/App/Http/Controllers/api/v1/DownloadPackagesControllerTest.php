<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Controllers\api\v1;

use App\Http\Controllers\api\v1\DownloadPackagesController;
use PhpCfdi\SatWsDescargaMasiva\Service;
use PhpCfdi\SatWsDescargaMasiva\Services\Download\DownloadResult;
use PhpCfdi\SatWsDescargaMasiva\Shared\StatusCode;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

final class DownloadPackagesControllerTest extends TestCase
{
    public function testDownloadMethodCallServiceDownload(): void
    {
        $packageId = 'foo';
        $downloadResult = new DownloadResult(new StatusCode(5000, 'message'), 'content');
        /** @var Service&MockObject $service */
        $service = $this->createMock(Service::class);

        $service->expects($this->once())->method('download')
            ->with($packageId)
            ->willReturn($downloadResult);

        $controller = new class extends DownloadPackagesController
        {
            public function download(Service $service, string $packageId): DownloadResult
            {
                return parent::download($service, $packageId);
            }
        };

        $controller->download($service, $packageId);
    }
}
