<?php

namespace Araiyusuke\FakeApi;

use Illuminate\Support\Facades\Validator;

class ConfigYmlValidator {

    public function make(array $array) {

        Validator::extend('key_match', function ($attribute, $value, $parameters, $validator) {
            $keys = explode(".", $attribute);
            $target = end($keys);
            return in_array($target, $parameters);      
        });
        
        Validator::extend('only_one_key', function ($attribute, $value, $parameters, $validator) {
            $nonMatch = array_key_exists("responseJsonFile", $value) === true
             && 
             array_key_exists("responseJson", $value) === true;

             return !$nonMatch;
        });

        $rules["*.*.statusCode"] = 'digits:3';
        $rules["*.*.auth"] = 'bool';
        $rules["*.*.description"] = 'string';
        $rules["*.*"] = 'required|key_match:post,get';
        $rules["*.*"] = 'required|only_one_key:test,sakana';

        $validation = Validator::make(
            $array, $rules, [
                '*.*.key_match' => ':attributeは、正しくありません',
                '*.*.statusCode.digits' => ':attributeは3桁の数字を指定してください',
            ]
        );
        
        return $validation;
    }
}
