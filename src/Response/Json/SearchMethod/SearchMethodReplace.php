<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json\SearchMethod;

use Exception;
use Araiyusuke\FakeApi\Faker\FakerCallBuilder;
use Araiyusuke\FakeApi\Faker\FakeMethodAdapter;

use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethod;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodType;

/**
 * Undocumented class
 */
class SearchMethodReplace {
    
    private FakeMethodAdapter $faker;

    public function __construct(FakeMethodAdapter $fakerMethods) 
    {
        $this->faker = $fakerMethods;
    }

    /**
     * 文字列の置き換え
     *
     * @param string $search
     * @param string $replace
     * @param string $subject
     * @return void
     */
    public function replace(string $search, string $replace, string &$subject)
    {
        $subject = str_replace($search, $replace, $subject);
    }

    /**
     * メソッド反映済みのレスポンスJSONを返す
     *
     * @param string $subject
     * @return string
     */
    public function perform(string $subject): string
    {
        $searcher = new SearchMethod(SearchMethodType::cases(), $subject);
        
        foreach($searcher->matchAll() as $match) { 

            $builder = new FakerCallBuilder;
            $builder->setInstance($this->faker);
            $builder->setMethod($match->getMethod());

            try {
                    
                $replace = $builder->call();

                $this->replace(
                    $match->getPattern(), 
                    $replace,
                    $subject
                );

            } catch(Exception $e) {
                //print("Error");
            }
        }
        return $subject;
    }
}