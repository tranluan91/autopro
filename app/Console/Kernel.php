<?php

namespace App\Console;

use App\Console\Commands\ConvertData;
use App\Console\Commands\CreateMegaMenu;
use App\Console\Commands\DeleteProduct;
use App\Console\Commands\ResetDailyDeployWebsite;
use App\Console\Commands\CreateAccount;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ConvertData::class,
        CreateMegaMenu::class,
        ResetDailyDeployWebsite::class,
        CreateAccount::class,
        DeleteProduct::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
