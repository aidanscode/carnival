<?php

namespace Tests\Carnival\Extension\Contracts;

use Carnival\Extension\Contracts\Extension;
use Carnival\Extension\Contracts\Installable;
use Mockery;
use Tests\Carnival\CarnivalTestCase;

class ExtensionTest extends CarnivalTestCase {
    public function testIsInstallableOnInstallableExtension() {
        $plugin = Mockery::mock(Extension::class, Installable::class)->makePartial();
        $this->assertTrue($plugin->isInstallable());
    }

    public function testIsInstallableOnNonInstallableExtension() {
        $plugin = Mockery::mock(Extension::class)->makePartial();
        $this->assertFalse($plugin->isInstallable());
    }
}
