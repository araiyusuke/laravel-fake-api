<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json\SearchMethod;

enum SearchMethodType 

{
    case methodWithId;
    case method;
    case methodParameter;
    case methodParameterWithId;

    public function getPattern(): string
    {
        return match($this) {
            Self::methodWithId => "%rand_([a-zA-Z0-9]+)_(\d+)%",
            Self::method => "%rand_([a-zA-Z0-9]+)%",
            Self::methodParameter => "%rand_([a-zA-Z0-9ぁ-んァ-ヶ一-龠々\s]+)\((.*)\)%",
            Self::methodParameterWithId => "%rand_([a-zA-Z0-9]+)\(([a-zA-Z0-9ぁ-んァ-ヶ一-龠々,\s]+)\)_(\d+)%"
        };
    }

    public function key(): array 
    {
        return match($this) {
            Self::methodWithId => array('search', 'method', 'id'),
            Self::method => array('search', 'method'),
            Self::methodParameter => array('search', 'method', 'argString'),
            Self::methodParameterWithId => array('search', 'method', 'argString','id')
        };
    }

    public function matchAll(string $subject): array 
    {
        $pattern = $this->getPattern();
        preg_match_all("/{$pattern}/", $subject, $matches, PREG_SET_ORDER);
        return $matches;
    }
}