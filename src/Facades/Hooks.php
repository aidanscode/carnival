<?php

namespace Carnival\Facades;

use Illuminate\Support\Facades\Facade;

class Hooks extends Facade {

    protected static function getFacadeAccessor() {
        return 'hooks';
    }
}