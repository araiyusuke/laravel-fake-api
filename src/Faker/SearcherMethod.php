<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

use Araiyusuke\FakeApi\Faker\Searcher;
use Araiyusuke\FakeApi\Faker\SearchMethodResultCollection;
use Araiyusuke\FakeApi\Faker\SearchMethodResult;

class SearcherMethod implements Searcher
{
   
    private array $types;
    private string $subject;

    /**
     * Undocumented function
     *
     * @param MatchType[] $types
     * @param string $subject
     */
    public function __construct(array $types, string $subject)
    {
        $this->types = $types;
        $this->subject = $subject;
    }

    public function matchAll(): SearchMethodResultCollection 
    {
        $result = new SearchMethodResultCollection();

        foreach( $this->types as $type) { 

            $matchAll = $type->matchAll($this->subject);
            
            foreach ($matchAll as $match) {

                foreach($type->key() as $key => $value) {
                    $$value = $match[$key];
                }
    
                $result->add(
                    new SearchMethodResult($search, $method, $arg ?? null, $id ?? null)
                );
            }
        }

        return $result;
    }
}