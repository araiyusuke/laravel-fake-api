<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Settings;

class SettingManager {

    private static $instance;

    private $lang;  

    private function __construct()
    {
        // 環境変数からlangを取得
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Self();
        }
        return self::$instance;
    }

    public function getLang(): string
    {
        return $this->lang;
    }

    public function setLang(string $lang) 
    {
        $this->lang = $lang;
    }

    public final function __clone()
    {
        throw new \Exception('This Instance is Not Clone');
    }

    public final function __wakeup()
    {
        throw new \Exception('This Instance is Not unserialize');
    }
}