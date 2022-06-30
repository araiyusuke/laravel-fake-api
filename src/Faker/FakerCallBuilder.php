<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;
use Araiyusuke\FakeApi\Config\Collections\Method;

class FakerCallBuilder {

    private FakeMethodAdapter $instance;
    private Method  $method;

    public function setInstance(FakeMethodAdapter &$instance): void
    {
        $this->instance = $instance;
    }

    public function setMethod(Method $method): void
    {
        $this->method = $method;
    }

    public function call(): mixed
    {
        return $this->method->call($this->instance);
    }
}