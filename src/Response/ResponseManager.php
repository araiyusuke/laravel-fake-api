<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response;

use Araiyusuke\FakeApi\FakerManager;

class ResponseManager {
        
    /**
     * レスポンスを生成する
     *
     * @param integer $statusCode
     * @param mixed $body
     * @return mixed
     */
    public static function generator(int $statusCode, mixed $body): mixed { 
        return response($body, $statusCode)
             ->header('Content-Type', 'application/json');
    }
}