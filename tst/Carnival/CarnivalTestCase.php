<?php

namespace Tests\Carnival;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class CarnivalTestCase extends TestCase {
    protected function tearDown() : void {
        parent::tearDown();

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }
}
