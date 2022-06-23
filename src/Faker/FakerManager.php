<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Faker\Factory as FakerFactory; 
use Araiyusuke\FakeApi\Faker\FakerCallBuilder;
use Araiyusuke\FakeApi\Faker\MatchType;

class MatchResultCollection  {

    private array $items = array();

    public function add(MatchResultCollectionItem $item) 
    {
        array_push($this->items, $item);
    }

    public function getCount(): int 
    {
        return count($this->items);
    }

    public function get(): array 
    {
        return $this->items;
    }    
}

class MatchResultCollectionItem {
    
    public function __construct(
        private string $search, private string $method, private int|float|string|null $arg = null,
         private ?string $id = null)
    {
        $this->search = $search;
        $this->method = $method;
        $this->arg = $arg;
        $this->id = $id;
    }

    public function getSearch(): string 
    {
        return $this->search;
    }

    public function getMethod(): string 
    {
        return $this->method;
    }

    public function getArg(): int|float|string|null 
    {
        return $this->arg;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}

interface Matcher 
{
    public function __construct(MatchType $type);
}

class FakerMethodMatcher implements Matcher
{
   
    public function __construct(MatchType $type)
    {
        $this->type = $type;
    }

    public function matchAll($subject): MatchResultCollection 
    {

        $result = new MatchResultCollection();
        $matchAll = $this->type->matchAll($subject);

        foreach ($matchAll as $match) {

            foreach($this->type->key() as $key => $value) {
                $$value = $match[$key];
            }

            $result->add(
                new MatchResultCollectionItem($search, $method, $param ?? null, $id ?? null)
            );
        }

        return $result;
    }
}

class FakerManager {
    
    private string $lang;
    private $faker;

    public function __construct(string $lang) 
    {
        $this->lang = $lang;
        $this->faker = FakerFactory::create($lang);
    }

    public function getLang(): string 
    {
        return $this->lang;
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