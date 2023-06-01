<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;

class SyncDBSatCatalogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:sync:db:sat:catalogs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create data base of phpcfdi/resources-sat-catalogs';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $lasTagInfo = $this->getLastTagResourcesSatCatalogs();
        $this->downloadLastTagResourcesSatCatalogs($lasTagInfo->nameZip, $lasTagInfo->urlZip);
        $this->extractZip($lasTagInfo->nameZip);
        $this->createFileDataBaseCatalogs();
        $this->importSchemaAndData();
        $this->deleteFileZipAndSatCatalogs($lasTagInfo->nameZip);
        return 0;
    }

    private function getLastTagResourcesSatCatalogs(): object
    {
        $this->comment('Getting last tag from phpcfdi/resources-sat-catalogs...');
        $response = Http::get('https://api.github.com/repos/phpcfdi/resources-sat-catalogs/tags');
        $versionZip = $response->collect()->get(0);

        return (object) [
            'nameZip' => $versionZip['name'] . '.zip',
            'urlZip' => $versionZip['zipball_url'],
            'version' => $versionZip['name'],
        ];
    }

    private function downloadLastTagResourcesSatCatalogs($nameZip, $urlZip): void
    {
        $this->info('starting download of ' . $nameZip);
        $path = Storage::path($nameZip);
        dump($path);
        Storage::put($nameZip, Http::get($urlZip)->body());
        $this->info('Download completed');
    }

    private function extractZip($nameFileZip): void
    {
        $this->info('Start ExtractZip');
        $storagePath = $this->getStoragePath();
        if (Storage::exists($nameFileZip)) {
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

    private function importSchemaAndData(): void
    {
        
        dump( Storage::disk('local')->allDirectories());
        $directory = Storage::disk('local')->directories('phpcfdi-resources-sat-catalogs')[0];
        $storagePath = $this->getStoragePath();

        $command = "cat ${storagePath}${directory}/database/schemas/*.sql";
        $command .= " ${storagePath}${directory}/database/data/*.sql ";
        $command .= "| sqlite3 ${storagePath}db/catalogs.sqlite";

        $process = Process::fromShellCommandline($command);
        $process->run();

        if (! $process->isSuccessful()) {
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

    private function getStoragePath(): string
    {
        $storagePath = Storage::disk('local')->path('');

        return explode('/api-descargar-cfdi/', $storagePath)[1];
    }
}
