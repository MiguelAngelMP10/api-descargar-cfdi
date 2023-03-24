<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\CreateToken;
use App\Console\Commands\CreateUser;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @var string[] */
    protected $commands = [
        CreateUser::class,
        CreateToken::class
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sw:sync:sat:catalogs')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/sw_sync_sat_catalogs.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
