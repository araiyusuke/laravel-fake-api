<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Exception;
use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;
use Araiyusuke\FakeApi\Config\Collections\Method;

final class FakerCallBuilder {

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

    public function call(): string
    {
        if (method_exists($this->instance, $this->method->getName()) === false) {
            throw new Exception('You tried to call a method that does not exist');
        }
       
        if ($this->method->isArg()) {
            
            $arg = $this->method->getArg();
            
            if ($this->method->getName() === "randomElement") {
                $res = call_user_func_array(array($this->instance, $this->method->getName()), array($arg)); 
            } else {
                $res = call_user_func_array(array($this->instance, $this->method->getName()), $arg);
            }
        
        } else {
            $res = call_user_func(array($this->instance, $this->method->getName()));
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
}