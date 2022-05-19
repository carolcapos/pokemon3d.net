<?php

namespace App\Console;

use App\Console\Commands\NotifyGameUpdate;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunHealthChecksCommand;

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
        $schedule->command('p3d:skinuserupdate')->hourlyAt(10);
        $schedule->command('server:pingall')->hourly();
        $schedule->command('gj:update-trophies')->hourly();
        $schedule->command('github:syncrelease')->dailyAt('00:00');
        $schedule->command('discord:syncroles')->dailyAt('12:00');
        $schedule->command('discord:syncuserroles')->dailyAt('12:10');
        $schedule->command('activity:cleanup')->dailyAt('01:00');
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();
        $schedule->command(NotifyGameUpdate::class)->dailyAt('00:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
