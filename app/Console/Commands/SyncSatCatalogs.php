<?php

namespace App\Console\Commands;

use App\Helpers\WriteCatalogControllerSat;
use App\Helpers\WriteCatalogModelSat;
use App\Helpers\WriteCatalogRouteApi;
use App\Helpers\WriteTestControllerCatalogSat;
use App\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;

class SyncSatCatalogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:sync:sat:catalogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync phpcfdi/resources-sat-catalogs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Start sync sat catalogs.');
        $lasTagInfo = $this->getLastTagResourcesSatCatalogs();
        $config = Config::firstWhere('name', 'resources-sat-catalogs-version');
        if ($config->value !== $lasTagInfo->version) {
            $this->downloadLastTagResourcesSatCatalogs($lasTagInfo->nameZip, $lasTagInfo->urlZip);
            $this->extractZip($lasTagInfo->nameZip);
            $this->createFileDataBaseCatalogs();
            $this->importSchemaAndData();
            if (env('APP_ENV') === 'local') {
                $this->createModelTableCatalog();
            }
            $this->deleteFileZipAndSatCatalogs($lasTagInfo->nameZip);
            $config->update([
                'id' => 1,
                'name' => 'resources-sat-catalogs-version',
                'value' => $lasTagInfo->version,
            ]);

            return 0;
        }
        $this->question('Sat catalogs resources are synchronized');

        return 0;
    }

    private function downloadLastTagResourcesSatCatalogs($nameZip, $urlZip): void
    {
        $this->info('starting download of ' . $nameZip);
        Storage::disk('local')->put($nameZip, Http::get($urlZip)->body());
        $this->info('Download completed');
    }

    private function getLastTagResourcesSatCatalogs(): object
    {
        $this->comment('Getting last tag from phpcfdi/resources-sat-catalogs...');
        $response = Http::get('https://api.github.com/repos/phpcfdi/resources-sat-catalogs/tags');
        $versionZip = $response->collect()->get(0);

        return (object)[
            'nameZip' => $versionZip['name'] . '.zip',
            'urlZip' => $versionZip['zipball_url'],
            'version' => $versionZip['name'],
        ];
    }

    private function importSchemaAndData(): void
    {
        $directory = Storage::disk('local')->directories('phpcfdi-resources-sat-catalogs')[0];
        $storagePath = $this->getStoragePath();

        $command = "cat ${storagePath}${directory}/database/schemas/*.sql";
        $command .= " ${storagePath}${directory}/database/data/*.sql ";
        $command .= "| sqlite3 ${storagePath}db/catalogs.sqlite";

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    private function deleteFileZipAndSatCatalogs($nameFileZip): void
    {
        Storage::delete($nameFileZip);
        $this->comment('Delete ' . $nameFileZip);
        Storage::deleteDirectory('phpcfdi-resources-sat-catalogs');
        $this->comment('Delete phpcfdi-resources-sat-catalogs');
    }

    private function extractZip($nameFileZip): void
    {
        $this->info('Start ExtractZip');
        $storagePath = $this->getStoragePath();
        if (Storage::disk('local')->exists($nameFileZip)) {
            $path = Storage::path($nameFileZip);
            $zip = new ZipArchive();
            $res = $zip->open($path);
            if ($res === true) {
                $zip->extractTo($storagePath . 'phpcfdi-resources-sat-catalogs');
                $zip->close();
            }
        }
        $this->info('End ExtractZip');
    }

    private function createFileDataBaseCatalogs(): void
    {
        $pathDataBase = 'db/catalogs.sqlite';
        Storage::disk('local')->put($pathDataBase, '');
        $this->info('Database created in path ' . $pathDataBase);
    }

    private function createModelTableCatalog(): void
    {
        $connection = DB::connection('sqlite_catalogs');
        $tables = $connection->select("SELECT name FROM sqlite_master WHERE type = 'table'");
        foreach ($tables as $table) {
            $nameTable = $table->name;
            WriteCatalogModelSat::writeModel(Str::studly($nameTable), $nameTable);
            $this->info('Created Model ' . Str::studly($nameTable) . ' of the table ' . $nameTable);

            $columnsFilter = $connection
                ->selectOne("select group_concat(\"'\" || name || \"'\", ',\n            ')
                                AS filterColumns
                                from pragma_table_info('" . $nameTable . "')");

            WriteCatalogControllerSat::writeController(Str::studly($nameTable), $columnsFilter->filterColumns);
            $this->info('Created Controller ' . Str::studly($nameTable) . 'Controller of the model ' .
                Str::studly($nameTable));

            WriteTestControllerCatalogSat::writeControllerTest(Str::studly($nameTable), $nameTable);
            $this->info('Created Test of ' . Str::studly($nameTable) . 'Controller ');
        }
        WriteCatalogRouteApi::writeApi($tables);
        $this->info('Created routers/api-catalogs.php');
    }

    private function getStoragePath(): string
    {
        return Storage::disk('local')->path('');
    }
}
