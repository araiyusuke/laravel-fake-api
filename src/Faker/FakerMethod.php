<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

class FakerMethod {
    
    private string $name;
    private mixed $arg;

    public function getName(): string {
        return $this->name;
    }

    public function getArg(): mixed {
        return $this->arg;
    }
}