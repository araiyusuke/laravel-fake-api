<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

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