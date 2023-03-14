<?php

namespace Tests\Carnival\Providers;

use Carnival\Hooks\HookManager;
use Carnival\Providers\HookServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Tests\Carnival\CarnivalTestCase;

class HookServiceProviderTest extends CarnivalTestCase {

    public function testHookServiceProviderCanRegisterHookLibraryFacade() {
        $application = Mockery::mock(Application::class);
        $hookServiceProvider = new HookServiceProvider($application);
        $application->shouldReceive('bind')->with(
            'hooks', 
            Mockery::on(fn ($argument) => is_callable($argument) && $argument() instanceof HookManager )
        )->once();
        $hookServiceProvider->register();
    }

}