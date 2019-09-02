<?php namespace DashboardersHeaven\Console;

use App\Console\Commands\PostMilestones;
use App\Console\Commands\UpdateManifest;
use DashboardersHeaven\Console\Commands\CreateGamerCommand;
use DashboardersHeaven\Console\Commands\GamersCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersClipsCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersGamesCommand;
use DashboardersHeaven\Console\Commands\UpdateGamersScreenshotsCommand;
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
        CreateGamerCommand::class,
        GamersCommand::class,
        UpdateGamersCommand::class,
        UpdateGamersGamesCommand::class,
        UpdateGamersClipsCommand::class,
        UpdateGamesCommand::class,
        UpdateGamersScreenshotsCommand::class,
        \Bugsnag\BugsnagLaravel\Commands\DeployCommand::class,
        PostMilestones::class,
        UpdateManifest::class,
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
        $schedule->command('destiny:milestones')
            ->weeklyOn(2, '12:30')
            ->timezone('America/Chicago')
            ->withoutOverlapping();

        $schedule->command('destiny:manifest', ['--force'])
            ->everyThirtyMinutes()
            ->timezone('America/Chicago')
            ->withoutOverlapping();

        $schedule->command('destiny:milestones', ['--milestone' => 534869653])
            ->weeklyOn(5, '12:30')
            ->timezone('America/Chicago')
            ->withoutOverlapping();

        $gamers = Gamer::all();
        foreach ($gamers as $gamer) {
            $safeGamertag = str_replace(' ', '_', $gamer->gamertag);
            $schedule->command('games:update')
                     ->name('Update games')
                     ->daily()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/games-update.log"));

            $schedule->command('gamers', [$gamer->xuid])
                     ->name('Update ' . $gamer->gamertag)
                     ->hourly()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/{$safeGamertag}.log"));

            $schedule->command('gamers:clips', [$gamer->xuid])
                     ->name('Update ' . $gamer->gamertag . '\'s clips')
                     ->everyThirtyMinutes()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/{$safeGamertag}-clips.log"));

            $schedule->command('gamers:screenshots', [$gamer->xuid])
                     ->name('Update ' . $gamer->gamertag . '\'s screenshots')
                     ->everyThirtyMinutes()
                     ->withoutOverlapping()
                     ->sendOutputTo(storage_path("logs/commands/{$safeGamertag}-screenshots.log"));
        }
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
