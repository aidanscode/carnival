<?php

namespace Tests\Hooks;

use Carnival\Hooks\HookManager;
use Tests\Carnival\CarnivalTestCase;
use Tests\Carnival\Data\Topics\ExampleTopic;

class HookManagerTest extends CarnivalTestCase {

    const EXAMPLE_NUMBER = 0;

    protected $hookSystem;
    protected $exampleTopic;

    public function setUp() : void {
        parent::setUp();

        $this->hookSystem = new HookManager;
        $this->exampleTopic = new ExampleTopic(self::EXAMPLE_NUMBER);
    }

    public function testTopicInHookListWillBeExecuted() {
        $this->addExampleTopicToHookList();
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(1, $this->exampleTopic->getNumber());
    }

    public function testTopicNotInHookListWillNotBeExecuted() {
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(0, $this->exampleTopic->getNumber());
    }

    public function testCanExecuteMultipleOfTheSameTopics() {
        $this->addMultipleTopicsToHookList();
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(3, $this->exampleTopic->getNumber());
    }

    private function addExampleTopicToHookList() : void {
        $this->hookSystem->register(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 1);
        });
    }

    private function addMultipleTopicsToHookList() : void  {
        $this->hookSystem->register(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 1);
        });

        $this->hookSystem->register(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 2);
        });
    }
}