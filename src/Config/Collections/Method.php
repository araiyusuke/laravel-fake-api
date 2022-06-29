<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Collections;

use Exception;
use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;

class Method {
    
    public function __construct(
        private string $name,
        private int|float|string|null $arg = null
    ) {}

    public function call(FakeMethodAdapter &$instance): mixed
    { 
        if (method_exists($instance, $this->name) === false) {
            throw new Exception('You tried to call a method that does not exist');
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