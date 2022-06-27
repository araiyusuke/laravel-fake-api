<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Araiyusuke\FakeApi\Response\Response;
use Araiyusuke\FakeApi\Config\Collections\PathCollection;

class FakerApi 
{

    static string $lang;

    /**
     * Fakerの言語設定
     *
     * @param string $lang
     * @return void
     */
    static function setLang(string $lang): void
    {
        self::$lang = $lang;
    }

    /**
     * 設定ファイルから取得したPathsコレクション情報をもとにAPIのルーティングを登録する
     *
     * @param PathCollection $paths
     * @param string $lang
     * @param [type] $response
     * @return void
     */
    public static function registRoute(PathCollection $paths, Response $response = new Response): void 
    {
        $route = new Routing($paths, $response);
        $route->regist();
    }

}