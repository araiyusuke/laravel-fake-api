<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;
use Araiyusuke\FakeApi\Faker\MatchType;
use Araiyusuke\FakeApi\Faker\FakerMethodMatcher;
use Faker\Factory as FakerFactory; 

class SearchReplace {
    
    private $faker;

    public function __construct(string $lang) 
    {
        $this->faker = FakerFactory::create($lang);
    }

    public function getFaker()
    {
        return $this->faker;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function replace(string $search, string $replace, string &$subject)
    {
        $subject = str_replace($search, $replace, $subject);
    }

    /**
     * rand_method_id
     * rand_method
     * rand_method
     *
     * @param string $subject
     * @return string
     */
    public function assign(string $subject): string
    {

        foreach(MatchType::cases() as $type) {  

            $matcher = new FakerMethodMatcher($type);
        
            foreach($matcher->matchAll($subject)->get() as $match) {
                        
                $builder = new FakerCallBuilder;
                $builder->setInstance($this->faker);
                $builder->setMethod($match->getMethod());
                $builder->setArg($match->getArg());

                $this->replace(
                    // 置き換える文字列
                    $match->getSearch(), 
                    // 置き換える文字列
                    $builder->call(),
                    $subject
                );
            }
        }
      
        return $subject;
    }
}