<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;
use Araiyusuke\FakeApi\Faker\MatchType;
use Araiyusuke\FakeApi\Faker\FakerMethodMatcher;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
// use Faker\Factory as FakerFactory; 
use Exception;
class SearchReplace {
    
    private FakerMethod $faker;

    public function __construct(string $lang) 
    {
        $this->faker = new DefaultFakerMethod($lang);
        // $this->faker = FakerFactory::create($lang);
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
     * 文字列の置き換えを実行する
     *
     * @param string $subject
     * @return string
     */
    public function apply(string $subject): string
    {

        foreach(MatchType::cases() as $type) {  

            $matcher = new FakerMethodMatcher($type);
        
            foreach($matcher->matchAll($subject)->get() as $match) {
                        
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
        }
      
        return $subject;
    }
}