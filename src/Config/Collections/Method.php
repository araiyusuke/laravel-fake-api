<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Collections;

use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;
use Araiyusuke\FakeApi\Exceptions\InvalidMethodException;

class Method {
    
    public function __construct(
        private string $name,
        private ?array $arg = null
    ) {}

    public function call(FakeMethodAdapter &$instance): mixed
    { 
        if (method_exists($instance, $this->name) === false) {
            throw new InvalidMethodException('You tried to call a method that does not exist');
        }
       
        if ($this->isArg()) {
            
            $arg = $this->getArg();

            if ($this->name === "randomElement") {
                $res = call_user_func_array(array($instance, $this->name), array($arg)); 
            } else {
                $res = call_user_func_array(array($instance, $this->name), $arg);
            }
        
        } else {
            $res = call_user_func(array($instance, $this->name));
        }
        
        switch(gettype($res)) {
            case 'integer':
                $res = strval($res);
                break;
            case 'boolean':
                $res = $res ? "true" : "false";
                break;
            // phpは言語仕様でgetypeで取得した型floatがdoubleになる
            case 'double':
                $res = sprintf('%f', $res);
                break;
        }

        return $res;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArg(): ?array 
    {
        return $this->arg;
    }

    public function isArg(): bool 
    {
        return is_null($this->arg) === false;
    }
}