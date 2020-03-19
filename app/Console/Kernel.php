<?php

namespace App\Console;

use App\Console\Commands\AgentStringParseConsole;
use App\Console\Commands\EmailAddConsole;
use App\Console\Commands\TeamRolesSync;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    private string $logDirectory = '/site/logs/cronPhpRun.log';

    /**
     * The Artisan commands provided by your application.
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule
            ->command(EmailAddConsole::class)
            ->everyFifteenMinutes();

        $schedule
            ->command(TeamRolesSync::class)
            ->hourly();

        $schedule->command(
            AgentStringParseConsole::class,
            [
                '--minutesBack=70',
            ]
        )
            ->hourly()
            ->runInBackground()
            ->withoutOverlapping(120)
            ->appendOutputTo($this->logDirectory)
            ->onOneServer();

        $schedule
            ->command('telescope:prune')
            ->daily();

        $schedule
            ->command('websockets:clean')
            ->daily();

        $schedule
            ->command('horizon:snapshot')
            ->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
