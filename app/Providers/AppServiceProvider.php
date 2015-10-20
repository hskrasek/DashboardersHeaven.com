<?php namespace DashboardersHeaven\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use DashboardersHeaven\Events\GameCreated;
use DashboardersHeaven\Game;
use DashboardersHeaven\Services\ClipService;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Game::created(function (Game $game) {
            $dispatcher = $this->app->make('events');
            $dispatcher->fire(new GameCreated($game));
        });

        Game::updated(function (Game $game) {
            $dispatcher = $this->app->make('events');
            $dispatcher->fire(new GameCreated($game));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() === 'local') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $logger = $this->app->make('log')->getMonolog();

        $syslog    = new SyslogHandler('papertrail');
        $formatter = new LineFormatter('%channel%.%level_name%: %message% %context% %extra%');
        $syslog->setFormatter($formatter);

        $logger->pushHandler($syslog);

        $this->app->singleton(ClipService::class, function () {
            return new ClipService;
        });
    }
}
