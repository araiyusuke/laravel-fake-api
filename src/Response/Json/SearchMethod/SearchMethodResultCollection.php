<?php declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json\SearchMethod;

use Araiyusuke\FakeApi\Faker\SearchResult;
use IteratorAggregate;
use ArrayIterator;

final class SearchMethodResultCollection implements IteratorAggregate
{
    public function __construct(private array $attributes = [])
    {
    }

    /**
     * @return SearchResult[]|ArrayIterator
     */
    #[ReturnTypeWillChange]
    public function getIterator(): array|ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }

     /**
     * @param SearchResult $searchResult
     */
    public function add(SearchMethodResult $searchResult): void
    {
        $this->attributes[] = $searchResult;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->attributes);
    }

}