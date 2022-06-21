<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response;

use Araiyusuke\FakeApi\FakerManager;

class ResponseManager {
        
    private string $lang;

    function __construct(string $lang) {
        $this->lang = $lang;
    }
    
    private function assign(string $body): string
    {
        $fakerManager = FakerManager::getInstance($this->lang);

        $rules = [
            'name', 'streetAddress', 'postcode', 'realText', 'address', 'password',
            'url', 'phoneNumber', 'country', 'city', 'safeEmail', 'creditCardNumber',
            'isbn13', 'isbn10', 'boolean', 'company', 'word', 'latitude', 'longitude',
            'numberBetween', 'random_float', 'uuid', 'prefecture', 'ipv4', 'kanaName',
            'firstKanaName', 'lastKanaName', 'year', 'month', 'time', 'dayOfMonth'
        ];


        $faker = $fakerManager->getFaker();   

        $replaced = str_replace("%id%", "5", $body);

        foreach($rules as $rule) {

            $matchCount = preg_match_all("/%rand_{$rule}_(\d+)%/", $replaced, $match, PREG_SET_ORDER);

            if ($matchCount > 0) {

                for ($i = 0; $i < count($match); $i++) {

                    $res = $faker->$rule();

                    switch(gettype($res)) {
                        case 'boolean':
                            $res = $res ? "true" : "false";
                            break;
                        case 'float':
                            $res = sprintf('%f', $res);
                            break;
                    }

                    $replaced = str_replace(current($match[$i]), $res, $replaced);
                }
                continue;
            }

            $matchCount = preg_match_all("/%rand_{$rule}%/", $replaced, $match, PREG_SET_ORDER);

            if ($matchCount > 0) {

                $res = $faker->$rule();

               

                switch(gettype($res)) {
                    
                    case 'boolean':
                        $res = $res ? "true" : "false";
                        break;
                    case 'double':
                        $res = sprintf('%f', $res);
                        break;
                    default:

                }
                
    
    
                $replaced = str_replace("%rand_{$rule}%", $res, $replaced);

                
            }
          
        }


        // rand_number(33)
        $matchCount = preg_match_all('/%rand_number\((\d+)\)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount !== 0) {
            for ($i = 0; $i < count($match); $i++) {
                $replaced = str_replace(current($match[$i]), strval($faker->randomNumber(($match[$i][1]))), $replaced);
            }
        }

        $matchCount = preg_match_all('/%rand_list\[(.+?)\]_(\d+)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount > 0) {

            foreach($match as $value) {

                list($x, $words, $id) = $value;

                $list = explode(",", $words);
                $randValue = trim($list[array_rand($list)]);
                $replaced = str_replace($x, $randValue, $replaced);
            }
        }

        // $matchCount = preg_match_all('/%rand_password_1\((\d+)\)%/', $replaced, $match, PREG_SET_ORDER);

        // if ($matchCount !== 0) {
        //     for ($i = 0; $i < count($match); $i++) {

        //         var_dump($match);
        //         $replaced = str_replace(current($match[$i]), strval($faker->randomNumber(($match[$i][1]))), $replaced);
        //     }
        //     // exit("マッチ");

        // }

        $matchCount = preg_match_all('/%rand_number\((\d+)\)_(\d+)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount > 0) {
            foreach($match as $value) {
                list($x, $digit, $id) = $value;
                $replaced = str_replace($x, strval($faker->randomNumber($digit)), $replaced);
            }
         
        }

        $matchCount = preg_match_all('/%rand_realText\((\d+)\)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount !== 0) {
            for ($i = 0; $i < count($match); $i++) {
                $replaced = str_replace(current($match[$i]), $faker->realText($match[$i][1]), $replaced);
            }
        }

        $matchCount = preg_match_all('/%rand_list\[(.+?)\]%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount !== 0) {
            for ($i = 0; $i < count($match); $i++) {
                $list = explode(",", $match[$i][1]);
                $randValue = trim($list[array_rand($list)]);
                $replaced = str_replace(current($match[$i]), $randValue, $replaced);
            }
        }

        // $matchCount = preg_match_all('/%rand_name_(\d+)%/', $replaced, $match, PREG_SET_ORDER);

        // if ($matchCount !== 0) {
        //     for ($i = 0; $i < count($match); $i++) {
        //         $replaced = str_replace(current($match[$i]), $faker->name(), $replaced);
        //     }
        // }

        // $matchCount = preg_match_all('/%rand_phoneNumber_(\d+)%/', $replaced, $match, PREG_SET_ORDER);

        // if ($matchCount !== 0) {
        //     for ($i = 0; $i < count($match); $i++) {
        //         $replaced = str_replace(current($match[$i]), $faker->phoneNumber(), $replaced);
        //     }
        // }


        $matchCount = preg_match_all('/%numberBetween\((.+?)\)_(\d+)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount > 0) {


            foreach($match as $value) {

                list($x, $words, $id) = $value;

                $range = explode(",", $words);
                
                $replaced = str_replace($x, strval($faker->numberBetween($range[0], $range[1])), $replaced);
            }
        }

        $matchCount = preg_match_all('/%randomFloat\((.+?)\)%/', $replaced, $match, PREG_SET_ORDER);

        if ($matchCount > 0) {


            foreach($match as $value) {

                list($x, $words) = $value;

                $range = explode(",", $words);
                
                $replaced = str_replace($x, strval($faker->randomFloat($range[0], $range[1], $range[2])), $replaced);
            }
        }




        return str_replace("%rand_safeEmail%", $faker->safeEmail, $replaced);
    }

    /**
     * レスポンスを生成する
     *
     * @param integer $statusCode
     * @param mixed $body
     * @return mixed
     */
    public function generator(int $statusCode, mixed $body): mixed {    
        return response($this->assign($body), $statusCode)
             ->header('Content-Type', 'application/json');
    }
}