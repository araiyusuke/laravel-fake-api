<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Araiyusuke\FakeApi\Faker\MatchType;
use Araiyusuke\FakeApi\Faker\SearcherMethod;
use Exception;

/**
 * Undocumented class
 */
class SearchReplaceMethod {
    
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
     * 置き換え後の文字列を返す
     *
     * @param string $subject
     * @return string
     */
    public function perform(string $subject): string
    {

        $searcher = new SearcherMethod(MatchType::cases(), $subject);
        
        foreach($searcher->matchAll() as $match) { 

            $builder = new FakerCallBuilder;
            $builder->setInstance($this->faker);
            $builder->setMethod($match->getMethod());
            $builder->setArg($match->getArg());

            try {
                    
                $replace = $builder->call();

                $this->replace(
                    $match->getSearch(), 
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