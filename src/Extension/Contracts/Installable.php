<?php

namespace Carnival\Extension\Contracts;

interface Installable {
    function isInstalled() : bool;
    function install() : void;
    function uninstall() : void;
}
