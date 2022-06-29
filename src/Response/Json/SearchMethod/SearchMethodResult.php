<?php declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json\SearchMethod;

use Araiyusuke\FakeApi\Config\Collections\Method;

final class SearchMethodResult
{
    public function __construct(
        private string $pattern,
        private Method $method,
        private ?string $id = null
    )
    {
        $this->pattern = $pattern;
        $this->method = $method;
        $this->id = $id;
    }

    public function getPattern(): string 
    {
        return $this->pattern;
    }

    public function getMethod(): Method 
    {
        return $this->method;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}