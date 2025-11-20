<?php

namespace Presentation;

use Illuminate\Support\ServiceProvider;

class PresentationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        $this->loadViewsFrom(__DIR__ . '/Views', 'presentation');
    }

    public function register(): void
    {
        //
    }
}
