<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Araiyusuke\FakeApi\Parser\AbstractParser;
use Araiyusuke\FakeApi\Response\ResponseManager;
use Araiyusuke\FakeApi\Settings\SettingManager;

class FakerApiFactory {

    private $validator; 
    private AbstractParser $parser;
    private ResponseManager $response;

    private function __construct(ConfigYmlValidator $validator, AbstractParser $parser, ResponseManager $response, string $lang) {
        $this->validator = $validator;
        $this->parser = $parser;
        $this->response = $response;
        SettingManager::getInstance()->setLang($lang);
    }

    /**
     * Undocumented function
     *
     * @param AbstractParser $parser
     * @return FakerApiFactory
     */
    public static function create(
        AbstractParser $parser,
        string $lang = "ja_JP"
    ): FakerApiFactory {
        
        return new FakerApiFactory(
                new ConfigYmlValidator(),
                $parser,
                new ResponseManager(),
                $lang
        );    
    }

    /**
     * 設定ファイルからルートを登録して反映する
     *
     * @return void
     */
    public function registRoutes(): void {
        $route = new RouteManager($this->parser, $this->response);
        $route->regist();
    }
}