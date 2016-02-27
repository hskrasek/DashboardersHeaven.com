<?php namespace DashboardersHeaven\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use DashboardersHeaven\Events\GameCreated;
use DashboardersHeaven\Game;
use DashboardersHeaven\Services\TitleService;
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

        $this->app->singleton(TitleService::class, function () {
            return new TitleService;
        });
    }
}
