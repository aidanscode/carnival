<?php

namespace Carnival\Providers;

use Carnival\Extension\ExtensionManager;
use Illuminate\Support\ServiceProvider;

class ExtensionsServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('extensions', fn() => new ExtensionManager);
    }
}
