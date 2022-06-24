<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Faker;

interface Searcher 
{
    public function __construct(array $matchType, string $subject);
}