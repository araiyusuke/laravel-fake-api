<?php

namespace Araiyusuke\FakeApi\Config\Collections;

use Illuminate\Support\Facades\Storage;
use Exception;

class Method {
    
    public function __construct(
        private string $name,
        private int|float|string|null $arg = null
    ) {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArg(): array 
    {
        $res = explode(",", $this->arg);
        $res= array_map('trim', $res);
        return $res;
    }


    public function isArg(): bool 
    {
        return is_null($this->arg) === false;
    }
}