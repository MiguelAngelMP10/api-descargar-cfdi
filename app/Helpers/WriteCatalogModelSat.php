<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class WriteCatalogModelSat
{
    public static function writeModel($nameClass, $nameTable): bool
    {
        $stringModel = "<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class ${nameClass} extends Model
{
    public \$incrementing = false;
    public \$timestamps = false;
    protected \$connection = 'sqlite_catalogs';
    protected \$table = '${nameTable}';
}
";

        return Storage::disk('catalogs_models')
            ->put($nameClass.'.php', $stringModel);
    }
}
