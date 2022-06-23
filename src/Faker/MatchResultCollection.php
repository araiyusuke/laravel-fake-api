<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

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
