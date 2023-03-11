<?php

namespace Carnival\Extension\Contracts;

use Illuminate\Support\Collection;

interface ExtensionManager {
    function register(Extension $plugin) : void;
    function isRegistered(Extension $plugin) : bool;
    function getExtensions() : Collection;

    function activate(Extension $plugin) : void;
    function deactivate(Extension $plugin) : void;

    function install(Extension $plugin) : void;
    function uninstall(Extension $plugin) : void;
}
