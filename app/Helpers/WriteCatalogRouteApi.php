<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WriteCatalogRouteApi
{
    public static function writeApi($tables): bool
    {
        $uses = self::generateUses($tables);
        $routers = self::generateRoute($tables);

        $stringApi = "<?php

{$uses}

Route::prefix('v1/catalogs')
    ->middleware('auth:sanctum')
    ->group(function () {
        {$routers}Route::get(
            'ccp-20-autorizaciones-naviero/{ccp_20_autorizaciones_naviero}',
            [Ccp20AutorizacionesNavieroController::class, 'show']
        )
            ->where('ccp_20_autorizaciones_naviero', '.*');
    });
";
        return Storage::disk('catalogs_api')
            ->put('api-catalogs-sat.php', $stringApi);
    }

    private static function generateUses($tables): string
    {
        $stringUses = '';
        foreach ($tables as $table) {
            $stringUses .= "use App\Http\Controllers\api\Catalogs\\" . Str::studly($table->name) . "Controller;\n";
        }
        return $stringUses . "use Illuminate\Support\Facades\Route;\nuse Orion\Facades\Orion;";
    }

    private static function generateRoute($tables): string
    {
        $strRouters = '';
        foreach ($tables as $table) {
            $connection = DB::connection('sqlite_catalogs');
            $numKeys = $connection->selectOne("SELECT count(name) as numKeys
                                                    FROM pragma_table_info('" . $table->name . "')
                                                 WHERE pk <> 0;
                                         ");

            $strRouters .= "Orion::resource('" . Str::slug(Str::limit($table->name, 32, ''))
                . "', " . Str::studly($table->name) . "Controller::class)\r";

            if ($numKeys->numKeys > 1) {
                $strRouters .= "            ->only(['index', 'search']);\r";
            } else {
                $strRouters .= "            ->only(['index', 'search', 'show']);\r";
            }

            $strRouters .= '        ';
        }
        return $strRouters;
    }
}
