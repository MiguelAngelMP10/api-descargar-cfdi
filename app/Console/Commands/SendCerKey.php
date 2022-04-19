<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Helpers\SatWsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;

class SendCerKey extends Command
{
    protected string $logo = <<<EOF
   .______    __    __  .______     ______  _______  _______   __
   |   _  \  |  |  |  | |   _  \   /      ||   ____||       \ |  |
   |  |_)  | |  |__|  | |  |_)  | |  ,----'|  |__   |  .--.  ||  |
   |   ___/  |   __   | |   ___/  |  |     |   __|  |  |  |  ||  |
   |  |      |  |  |  | |  |      |  `----.|  |     |  '--'  ||  |
   | _|      |__|  |__| | _|       \______||__|     |_______/ |__|
EOF;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sw:send:cer-key
                            {cer : certificate path}
                            {key : key path}
                            {--p|password= : Paswword FIEL}
                            {--copyFiel= : Copy the Electronic Signature files to local storage}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the files of a faithful to the server .cer and .key';

    protected string $contentCer;
    protected string $contentKey;
    protected Fiel $fiel;
    protected string $localStore = 'No';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info($this->logo);
        $certificatePath = $this->argument('cer');
        $keyPath = $this->argument('key');
        $password = $this->option('password');
        $password = is_null($password) ? $this->secret('What is the password?') : $password;
        $this->choiceLocalStore();

        try {
            $this->contentCer = file_get_contents($certificatePath);
            $this->contentKey = file_get_contents($keyPath);
            $satWsService = new SatWsService();
            $this->fiel = $satWsService->createFiel(
                $this->contentCer,
                $this->contentKey,
                $password
            );

            if ($this->fiel->isValid()) {
                $this->processIsValidFiel();
                return 0;
            }
            return 1;
        } catch (\Throwable $exception) {
            $this->newLine();
            $this->error($exception->getMessage());
            return 1;
        }
    }

    /**
     * @return void
     */
    private function processIsValidFiel(): void
    {
        $rfc = $this->fiel->getRfc();
        $this->copyFiles($rfc);
        $this->detailsFIEL($rfc, $this->fiel->isValid() ? 'Valid' : 'Invalid');
    }

    /**
     * @param string $rfc
     *
     * @return void
     */
    private function copyFiles(string $rfc): void
    {
        if ($this->localStore === 'Yes') {
            Storage::put('datos/' . $rfc . '/' . $rfc . '.cer', $this->contentCer);
            Storage::put('datos/' . $rfc . '/' . $rfc . '.key', $this->contentKey);
        }
    }

    /**
     * @param string $rfc
     * @param string $status
     *
     * @return void
     */
    private function detailsFIEL(string $rfc, string $status): void
    {
        $this->newLine(1);
        $this->info('Details of your electronic signature');
        $this->comment('RFC: ' . $rfc);
        $this->comment('FIEL status: ' . $status);
        $this->newLine(1);
    }

    /**
     * @return void
     */
    private function choiceLocalStore(): void
    {
        if (is_null($this->option('copyFiel'))) {
            $this->localStore = $this->choice(
                'Do you want your FIEL to be stored in our local storage?',
                ['Yes', 'No'],
                'No'
            );
        }
    }
}
