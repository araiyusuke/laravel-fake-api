<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Araiyusuke\FakeApi\Response\Response;
use Araiyusuke\FakeApi\Settings\SettingManager;
use Araiyusuke\FakeApi\Config\Collections\PathCollection;

class FakerApi 
{

    /**
     * 設定ファイルのPathsを使ってルーティング登録
     *
     * @return void
     */
    public static function registRoute(PathCollection $paths, string $lang = "ja_JP" , Response $response = new Response): void 
    {
        SettingManager::getInstance()->setLang($lang);
        $route = new Routing($paths, $response);
        $route->regist();
    }
}