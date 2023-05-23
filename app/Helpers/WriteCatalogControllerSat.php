<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class WriteCatalogControllerSat
{
    public static function writeController($nameClass, $columnsFilter): bool
    {
        $stringController = "<?php

namespace App\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\\{$nameClass};
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class ${nameClass}Controller extends Controller
{
    use DisableAuthorization;

    protected \$model = ${nameClass}::class;

    public function filterableBy(): array
    {
        return [
            ${columnsFilter},
        ];
    }
}
";
        return Storage::disk('catalogs_controllers')
            ->put($nameClass . 'Controller.php', $stringController);
    }
}
