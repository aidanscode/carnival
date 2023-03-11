<?php

namespace Tests\Carnival\Extension;

use Carnival\Extension\Contracts\Extension;
use Carnival\Extension\Contracts\Installable;
use Carnival\Extension\ExtensionManager;
use InvalidArgumentException;
use Mockery;
use Tests\Carnival\CarnivalTestCase;

class ExtensionManagerTest extends CarnivalTestCase {
    private ExtensionManager $extensionManager;
    private Extension $installableExtension;
    private Extension $nonInstallableExtension;

    protected function setUp() : void {
        parent::setUp();

        $this->extensionManager = new ExtensionManager;
        $this->installableExtension = Mockery::mock(Extension::class, Installable::class)->makePartial();
        $this->nonInstallableExtension = Mockery::mock(Extension::class)->makePartial();

        $this->installableExtension->shouldReceive('getName')->andReturn('InstallableExtension');
        $this->nonInstallableExtension->shouldReceive('getName')->andReturn('NonInstallableExtension');
    }

    public function testIsRegisteredOnUnregisteredExtension() {
        $this->assertFalse($this->extensionManager->isRegistered($this->installableExtension));
    }

    public function testIsRegisteredOnRegisteredExtension() {
        $this->extensionManager->register($this->installableExtension);
        $this->assertTrue($this->extensionManager->isRegistered($this->installableExtension));
    }

    public function testGetExtensionsWithNoneRegistered() {
        $this->assertEquals(collect(), $this->extensionManager->getExtensions());
    }

    public function testGetExtensionsWithExtensionsRegistered() {
        $this->extensionManager->register($this->installableExtension);
        $this->extensionManager->register($this->nonInstallableExtension);
        $this->assertEquals(
            collect([
                $this->installableExtension, $this->nonInstallableExtension
            ]),
            $this->extensionManager->getExtensions()
        );
    }

    public function testActivateOnUnregisteredExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->extensionManager->activate($this->nonInstallableExtension);
    }

    public function testActivateOnRegisteredExtension() {
        $this->extensionManager->register($this->nonInstallableExtension);
        $this->nonInstallableExtension->shouldReceive('activate')->once();
        $this->extensionManager->activate($this->nonInstallableExtension);
    }

    public function testDectivateOnUnregisteredExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->extensionManager->deactivate($this->nonInstallableExtension);
    }

    public function testDeactivateOnRegisteredExtension() {
        $this->extensionManager->register($this->nonInstallableExtension);
        $this->nonInstallableExtension->shouldReceive('deactivate')->once();
        $this->extensionManager->deactivate($this->nonInstallableExtension);
    }

    public function testInstallOnUnregisteredNonInstallableExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given extension must be registered: NonInstallableExtension");
        $this->extensionManager->install($this->nonInstallableExtension);
    }

    public function testInstallOnUnregisteredInstallableExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given extension must be registered: InstallableExtension");
        $this->extensionManager->install($this->installableExtension);
    }

    public function testInstallOnRegisteredNonInstallableExtension() {
        $this->extensionManager->register($this->nonInstallableExtension);
        $this->extensionManager->install($this->nonInstallableExtension);
        $this->nonInstallableExtension->shouldNotHaveReceived('install');
    }

    public function testInstallOnRegisteredInstallableExtension() {
        $this->extensionManager->register($this->installableExtension);
        $this->installableExtension->shouldReceive('install')->once();
        $this->extensionManager->install($this->installableExtension);
    }

    public function testUninstallOnUnregisteredNonInstallableExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given extension must be registered: NonInstallableExtension");
        $this->extensionManager->uninstall($this->nonInstallableExtension);
    }

    public function testUninstallOnUnregisteredInstallableExtension() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Given extension must be registered: InstallableExtension");
        $this->extensionManager->uninstall($this->installableExtension);
    }

    public function testUninstallOnRegisteredNonInstallableExtension() {
        $this->extensionManager->register($this->nonInstallableExtension);
        $this->extensionManager->uninstall($this->nonInstallableExtension);
        $this->nonInstallableExtension->shouldNotHaveReceived('uninstall');
    }

    public function testUninstallOnRegisteredInstallableExtension() {
        $this->extensionManager->register($this->installableExtension);
        $this->installableExtension->shouldReceive('uninstall')->once();
        $this->extensionManager->uninstall($this->installableExtension);
    }
}
