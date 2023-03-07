<?php

namespace Tests\Unit\Hooks;

use Carnival\Hooks\HookSystem;
use Tests\Carnival\CarnivalTest;
use Tests\Carnival\Unit\Data\Topics\ExampleTopic;

class HookSystemTest extends CarnivalTest {

    const EXAMPLE_NUMBER = 0;

    protected $hookSystem;
    protected $exampleTopic;

    public function setUp() : void {
        parent::setUp();

        $this->hookSystem = new HookSystem;
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

    public function testTopicInHookListCanBeRemoved() {
        $this->addExampleTopicToHookList();
        $this->hookSystem->remove(ExampleTopic::class);
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(0, $this->exampleTopic->getNumber());
    }

    public function testTopicNotInHookListCanNotBeRemoved() {
        $this->hookSystem->remove(ExampleTopic::class);
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(0, $this->exampleTopic->getNumber());
    }

    public function testCanExecuteMultipleOfTheSameTopics() {
        $this->addMultipleTopicsToHookList();
        $this->hookSystem->execute($this->exampleTopic);
        $this->assertEquals(3, $this->exampleTopic->getNumber());
    }

    private function addExampleTopicToHookList() : void {
        $this->hookSystem->add(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 1);
        });
    }

    private function addMultipleTopicsToHookList() : void  {
        $this->hookSystem->add(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 1);
        });

        $this->hookSystem->add(ExampleTopic::class, function () {
            $this->exampleTopic->setNumber($this->exampleTopic->getNumber() + 2);
        });
    }
}