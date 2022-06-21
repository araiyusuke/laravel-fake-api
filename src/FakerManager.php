<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Faker\Factory as FakerFactory; 

class FakerManager {
    
    private string $lang;
    private $faker;
    private static $instance;

    private int $rand;

    protected function __construct(string $lang) {
        $this->lang = $lang;
        $this->faker = FakerFactory::create($lang);
        $this->rand = mt_rand();
    }

    public function getLang(): string {
        return $this->lang;
    }

    public function getFaker() {
        return $this->faker;
    }

    public static function getInstance(string $lang)
    {
        if (!isset(self::$instance)) {
            self::$instance = new FakerManager($lang);    
        }

        return self::$instance;
    }
    
    // public static function getInstance(string $lang)
    // {


    //     if (!isset(self::$faker)) {
    //         self::$faker = FakerFactory::create($lang);    
    //     }

    //     return self::$faker;
    // }

    function __clone()
    {
        throw new RuntimeException("You can't clone this instance.");
    }

}