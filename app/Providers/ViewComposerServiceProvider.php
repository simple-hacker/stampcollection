<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Http\View\Composers\YearComposer');
        $this->app->singleton('App\Http\View\Composers\ThemeComposer');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.app', 'App\Http\View\Composers\YearComposer'
        );

        View::composer(
            'layouts.app', 'App\Http\View\Composers\ThemeComposer'
        );
    }
}
