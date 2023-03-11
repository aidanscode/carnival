<?php

namespace Carnival\Extension\Contracts;

abstract class Extension {
    abstract function getName() : string;
    abstract function getDescription() : string;
    abstract function getVersion() : string;
    abstract function getAuthor() : string;

    abstract function activate() : void;
    abstract function deactivate() : void;

    function isInstallable() : bool {
        return $this instanceof Installable;
    }
}
