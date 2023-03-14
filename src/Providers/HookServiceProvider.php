<?php

namespace Carnival\Providers;

use Illuminate\Support\ServiceProvider;
use Carnival\Hooks\HookManager;

class HookServiceProvider extends ServiceProvider {
    
    public function register() {
        $this->app->bind('hooks', fn() => new HookManager);
    }
}
