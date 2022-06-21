<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response;

use Araiyusuke\FakeApi\FakerManager;

class ResponseManager {
        
    private string $lang;

    function __construct(string $lang) {
        $this->lang = $lang;
    }
    
    /**
     * レスポンスを生成する
     *
     * @param integer $statusCode
     * @param mixed $body
     * @return mixed
     */
    public function generator(int $statusCode, mixed $body): mixed {    

        $fakerManager = FakerManager::getInstance($this->lang);

        return response($fakerManager->assign($body), $statusCode)
             ->header('Content-Type', 'application/json');
    }
}