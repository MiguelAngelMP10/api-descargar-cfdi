<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WriteTestControllerCatalogSat
{
    public static function writeControllerTest($nameClass, $nameTable): bool
    {
        $testIndex = self::writeTestIndex($nameTable);
        $testSearch = self::writeTestSearch($nameTable);
        $testShow = self::writeTestShow($nameTable);

        $stringControllerTest = "<?php

namespace Tests\Feature\Http\Controllers\api\Catalogs;

use App\Models\Catalogs\\${nameClass};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ${nameClass}ControllerTest extends TestCase
{
    use RefreshDatabase;

    {$testIndex}

    {$testSearch}

    {$testShow}
}
";
        return Storage::disk('catalogs_controllers_test')
            ->put($nameClass . 'ControllerTest.php', $stringControllerTest);
    }

    public static function writeTestIndex($nameTable): string
    {
        $route = Str::slug(Str::limit($nameTable, 32, ''));
        $nameTest = Str::slug(Str::limit($nameTable, 32, ''), '_');

        return '
    public function test_' . $nameTest . "_index(): void
    {
        \$this->sanctumAuthenticate();
        \$response = \$this->get('/api/v1/catalogs/" . $route . "');
        \$response->assertStatus(200);
        \$response->assertJsonStructure([
            'data' => [],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links',
            ]
        ]);
    }";
    }

    public static function writeTestSearch($nameTable): string
    {
        $connection = DB::connection('sqlite_catalogs');
        $columnFilter = $connection
            ->selectOne("select name AS filterColumns from pragma_table_info('" . $nameTable . "')");
        $route = Str::slug(Str::limit($nameTable, 32, ''));
        return '
    public function test_' . Str::slug(Str::limit($nameTable, 32, ''), '_') . "_search(): void
    {
        \$this->sanctumAuthenticate();
        \$response = \$this->postJson('/api/v1/catalogs/" . $route . "/search', ['filters' => [
            [
                'field' => '" . $columnFilter->filterColumns . "',
                'operator' => 'like',
                'value' => '%abc%'
            ]
        ]]);
        \$response->assertStatus(200);
        \$response->assertJsonStructure([
            'data' => [],
            'links' => [],
            'meta' => []
        ]);
    }";
    }

    public static function writeTestShow($nameTable): string
    {
        $connection = DB::connection('sqlite_catalogs');
        $numKeys = $connection->selectOne("SELECT count(name) as numKeys
                                                    FROM pragma_table_info('" . $nameTable . "')
                                                 WHERE pk <> 0;
                                         ");

        $route = Str::slug(Str::limit($nameTable, 32, ''));
        $nameTest = Str::slug(Str::limit($nameTable, 32, ''), '_');

        if ($numKeys->numKeys > 1) {
            return '';
        }

        $nameModel = Str::studly($nameTable);

        return '
    public function test_' . $nameTest . '_show(): void
    {
        \$this->sanctumAuthenticate();
        \$model = ' . $nameModel . '::first();
        \$keyName = \$model->getKeyName();
        \$response = \$this->get(\'/api/v1/catalogs/' . $route . '/\'.$model->{\$keyName});
        \$response->assertStatus(200);
        \$response->assertJsonStructure([
            \'data\' => []
        ]);
    }';
    }
}
