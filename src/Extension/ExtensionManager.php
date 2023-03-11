<?php

namespace Carnival\Extension;

use Carnival\Extension\Contracts\ExtensionManager as ExtensionManagerContract;
use Carnival\Extension\Contracts\Extension;
use Carnival\Extension\Contracts\Installable;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ExtensionManager implements ExtensionManagerContract {
    private Collection $extensions;

    public function __construct() {
        $this->extensions = new Collection();
    }

    public function register(Extension $extension) : void {
        $this->extensions->put(get_class($extension), $extension);
    }

    public function isRegistered(Extension $extension) : bool {
        return $this->extensions->has(get_class($extension));
    }

    public function getExtensions() : Collection {
        return $this->extensions->values();
    }

    public function activate(Extension $extension) : void {
        $this->actOnRegisteredExtension($extension, fn(Extension $extension) => $extension->activate());
    }

    public function deactivate(Extension $extension) : void {
        $this->actOnRegisteredExtension($extension, fn(Extension $extension) => $extension->deactivate());
    }

    public function install(Extension $extension) : void {
        $this->actIfInstallable($extension, fn(Extension&Installable $extension) => $extension->install());
    }

    public function uninstall(Extension $extension) : void {
        $this->actIfInstallable($extension, fn(Extension&Installable $extension) => $extension->uninstall());
    }

    private function actOnRegisteredExtension(Extension $extension, callable $callback) : void {
        if (!$this->isRegistered($extension)) {
            throw new InvalidArgumentException("Given extension must be registered: " . $extension->getName());
        }
        $callback($extension);
    }

    private function actIfInstallable(Extension $extension, callable $callback) : void {
        $this->actOnRegisteredExtension($extension, function(Extension $extension) use ($callback) {
            if ($extension->isInstallable()) {
                $callback($extension);
            }
        });
    }
}
