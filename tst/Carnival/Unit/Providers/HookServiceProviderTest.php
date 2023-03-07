<?php

namespace Tests\Carnival\Unit\Providers;

use Carnival\Providers\HookServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Tests\Carnival\CarnivalTest;

class HookServiceProviderTest extends CarnivalTest {

    public function testHookServiceProviderCanRegisterHookLibraryFacade() {
        $application = Mockery::mock(Application::class);
        $hookServiceProvider = new HookServiceProvider($application);
        $application->shouldReceive('bind');
        $hookServiceProvider->register();
        $application->shouldHaveReceived('bind')->once();
    }

}