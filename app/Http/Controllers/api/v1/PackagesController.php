<?php

declare(strict_types=1);

namespace App\Http\Controllers\api\v1;

use App\Helpers\SatWsService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\Rfc\Rfc;

class PackagesController extends Controller
{
    public function index(Rfc $rfc)
    {
        $satWsServiceHelper = new SatWsService();
        $path = $satWsServiceHelper->obtainPackagePath($rfc->getRfc(), '');
        $packageIds = [];
        foreach (Storage::files($path) as $packageFile) {
            $packageIds[] = substr(basename($packageFile), 0, -4);
        }
        return response()->json([
            'rfc' => $rfc,
            'packages' => $packageIds,
        ]);
    }

    public function download(Rfc $rfc, string $packageId)
    {
        $satWsServiceHelper = new SatWsService();
        $path = $satWsServiceHelper->obtainPackagePath($rfc->getRfc(), $packageId);
        if (! Storage::exists($path)) {
            return response()->json(['message' => "Package ${rfc}/${packageId} not found."], 404);
        }
        return Storage::response($path);
    }

    public function delete(Rfc $rfc, string $packageId)
    {
        $satWsServiceHelper = new SatWsService();
        $path = $satWsServiceHelper->obtainPackagePath($rfc->getRfc(), $packageId);
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        return response(null, 204);
    }
}
