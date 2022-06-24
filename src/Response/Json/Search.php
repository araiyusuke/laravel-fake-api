<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json;

interface Search
{
    public function __construct(array $matchType, string $subject);
}