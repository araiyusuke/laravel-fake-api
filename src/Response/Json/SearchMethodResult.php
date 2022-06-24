<?php declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json;

final class SearchMethodResult
{
    public function __construct(
        private string $search,
        private string $method,
        private int|float|string|null $arg = null,
        private ?string $id = null
    )
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