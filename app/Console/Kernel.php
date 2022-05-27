<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('createlog')->everyMinute()->runInBackground();
        $schedule->command('createsecondlog')->everyMinute()->runInBackground();

        // $schedule->command('createlog')->everyMinute()->sendOutputTo(public_path().'/output.txt');
        // $schedule->command('createlog')->everyTwoMinutes();
        // $schedule->command('createlog')->everyFifteenMinutes();

        // $schedule->command('createlog')->daily();
        // $schedule->command('createlog')->dailyAt('18:00');

        // $schedule->command('createlog')->twiceDaily(1,13);

        // $schedule->command('createlog')->weekly();
        // $schedule->command('createlog')->weeklyOn(2,'08:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
