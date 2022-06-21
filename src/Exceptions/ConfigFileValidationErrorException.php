<?php

namespace Araiyusuke\FakeApi\Exception;

use Exception;

class ConfigFileValidationErrorException extends Exception
{
     protected $messages = [];

     public function __construct($messages = '') {
        
        filter_var($messages, \FILTER_CALLBACK, ['options' => function ($v) {
            $this->messages[] = $v;
        }]);

        parent::__construct(reset($this->messages));
    }
    
    public function getMessages() {    
        return $this->messages;
    }
        
}