<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('dm-print-manager-down:status')->everyFiveMinutes()->weekdays()->between('08:00', '18:00');
        $schedule->command('iva-print-manager-down:status')->everyFiveMinutes()->weekdays()->between('08:00', '18:00');
        $schedule->command('dm-print-manager-emails-unticked:status')->everyFiveMinutes()->weekdays()->between('08:00', '18:00');
        $schedule->command('iva-print-manager-emails-unticked:status')->everyFiveMinutes()->weekdays()->between('08:00', '18:00');
        $schedule->command('ssrs-print-queue-overloaded:status')->everyFiveMinutes()->weekdays()->between('08:00', '18:00');
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
