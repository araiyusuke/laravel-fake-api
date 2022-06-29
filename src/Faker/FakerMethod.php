<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Exception;
use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;
use Araiyusuke\FakeApi\Config\Collections\Method;

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