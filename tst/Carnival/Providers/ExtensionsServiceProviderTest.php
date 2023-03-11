<?php

namespace Tests\Carnival\Providers;

use Carnival\Extension\ExtensionManager;
use Carnival\Providers\ExtensionsServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Tests\Carnival\CarnivalTestCase;

class ExtensionsServiceProviderTest extends CarnivalTestCase {
    public function testRegister() {
        $app = Mockery::mock(Application::class);
        $extensionsServiceProvider = new ExtensionsServiceProvider($app);
        $app->shouldReceive('bind')->with(
            'extensions',
            Mockery::on(fn ($argument) => is_callable($argument) && $argument() instanceof ExtensionManager)
        )->once();
        $extensionsServiceProvider->register();
    }
}
