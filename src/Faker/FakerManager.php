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
        private string $search, private string $method, private int|float|string|null $param = null,
         private ?string $id = null)
    {
        $this->search = $search;
        $this->method = $method;
        $this->param = $param;
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

    public function getParam(): int|float|string|null 
    {
        return $this->param;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}

interface Matcher 
{
    public function __construct(MatchType $type);
    public function getType(): MatchType;
    public function match(string $subject): bool;
    public function getSearch(): string;
    public function getReplace(): string;
}

class FakerMethodMatcher implements Matcher
{
    private string $pattern;
    private string $search;
    private string $method;
    
    private MatchResultCollection $result;

    public function __construct(MatchType $type)
    {
        $this->type = $type;
        $this->result = new MatchResultCollection;
    }

    public function extractAll(): MatchResultCollection 
    {
        return $this->result;
    }

    public function getType(): MatchType
    {
        return $this->type;
    }

    public function match(string $subject): bool
    {
        $matches = [];
        $pattern = $this->type->getPattern();
        preg_match_all("/{$pattern}/", $subject, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {

            foreach($this->type->key() as $key => $value) {
                $$value = $match[$key];
            }

            $this->result->add(
                new MatchResultCollectionItem($search, $method, $param ?? null, $id ?? null)
            );
        }
        return $this->result->getCount() > 0;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getReplace(): string 
    {
        return $this->replace;
    }

    public function getSearch(): string 
    {
        return "search";
    }

    public function setSearch(string $search) {
        $this->search = $search;
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

        $types = [
            MatchType::methodParameterWithId,
            MatchType::methodWithId ,
            MatchType::method ,
            MatchType::methodParameter,
            MatchType::methodParameterWithId,
        ];

        foreach($types as $type) {  

            $matcher = new FakerMethodMatcher($type);
            
            if ($matcher->match($subject)) {
    
                foreach($matcher->extractAll()->get() as $match) {
                        
                    $builder = new FakerCallBuilder;
                    $builder->setInstance($this->faker);
                    $builder->setMethod($match->getMethod());
                    $builder->setArg($match->getParam());

                      $this->replace(
                        // 置き換える文字列
                        $match->getSearch(), 
                        // 置き換える文字列
                        $builder->call(),
                        $subject
                    );
                }
            } 
        }
    
        return $subject;
    }
}