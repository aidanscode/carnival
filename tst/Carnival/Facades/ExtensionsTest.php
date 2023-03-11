<?php

namespace Tests\Carnival\Facades;

use Carnival\Facades\Extensions;
use ReflectionClass;
use Tests\Carnival\CarnivalTestCase;

class ExtensionsTest extends CarnivalTestCase {
    public function testGetFacadeAccessor() {
        $class = new ReflectionClass(Extensions::class);
        $method = $class->getMethod('getFacadeAccessor');
        $method->setAccessible(true);
        $this->assertEquals('extensions', $method->invoke(null));
    }
}
