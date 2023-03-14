<?php

namespace Carnival\Hooks;

use Carnival\Hooks\Topic;
use Illuminate\Support\Collection;

class HookManager {

    protected Collection $hooks;

    public function __construct() {
        $this->hooks = collect();
    }

    function register(string $eventClass, callable $callback) : void {
        data_set($this->hooks, $eventClass, data_get($this->hooks, $eventClass, collect())->push($callback));
    }
        
    function execute(Topic $event) : void {
        data_get($this->hooks, get_class($event), collect())->each(fn ($callback) => $callback($event));
    }
}