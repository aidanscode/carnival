<?php

namespace Tests\Carnival\Data\Topics;

use Carnival\Hooks\Topic;

class ExampleTopic implements Topic {

    protected $number;

    public function __construct(int $number) {
        $this->number = $number;
    }
    
    public function setNumber(int $number) : void {
        $this->number = $number;
    }

    public function getNumber() : int {
        return $this->number;
    }
}