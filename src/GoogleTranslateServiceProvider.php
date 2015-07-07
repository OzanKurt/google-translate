<?php

namespace Kurt\Google;

use Illuminate\Support\ServiceProvider;

class GoogleTranslateServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGoogleTranslate();
    }

    /**
     * Register Google Commands.
     *
     * @return void
     */
    private function registerGoogleTranslate()
    {
        $this->app->singleton(Translate::class, function () {
            return new Translate(Core::class);
        });
    }
}
