<?php namespace DashboardersHeaven\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use DashboardersHeaven\Gamer;
use DashboardersHeaven\Services\Titles\TitleService;
use Illuminate\Support\ServiceProvider;

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

        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);

        Bugsnag::registerCallback(function ($report) {
            /** @var \Illuminate\Http\Request $request */
            $request = $this->app->make('request');
            $gamer   = Gamer::whereGamertag($request->route('gamertag'))->first();
            if (!$gamer) {
                return;
            }
            $report->setUser([
                'id'       => $gamer->id,
                'gamertag' => $gamer->gamertag,
                'xuid'     => $gamer->xuid,
            ]);
        });
    }
}
