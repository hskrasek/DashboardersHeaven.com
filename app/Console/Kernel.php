<?php namespace DashboardersHeaven\Console;

use DashboardersHeaven\Console\Commands\GamersCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersClipsCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersGamesCommand;
use DashboardersHeaven\Console\Commands\UpdateGamesCommand;
use DashboardersHeaven\Gamer;
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
        GamersCommand::class,
        UpdateGamersCommand::class,
        UpdateGamersGamesCommand::class,
        UpdateGamersClipsCommand::class,
        UpdateGamesCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $gamers = Gamer::all();
        foreach ($gamers as $gamer) {
            \Log::debug('command.schedule', $gamer->toArray());
            $schedule->command('games:update')
                     ->name('Update games')
                     ->daily()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/games-update.log"));

            $schedule->command('gamers', [$gamer->xuid])
                     ->name('Update ' . $gamer->gamertag)
                     ->hourly()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/{$gamer->gamertag}.log"));

            $schedule->command('gamers:clips', [$gamer->xuid])
                     ->name('Update ' . $gamer->gamertag . '\'s clips')
                     ->everyThirtyMinutes()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/{$gamer->gamertag}-clips.log"));
        }
    }
}
