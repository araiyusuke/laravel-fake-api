<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Collections;

use Iterator;

class PathCollection implements Iterator {

    private $position = 0;

    private array $array = [];

    public function set(Path $path) {
        array_push($this->array, $path);
    }

    public function all(): array {
        return $this->array;
    }

    public function __construct() {
        $this->position = 0;
    }

    public function rewind(): void {
        $this->position = 0;
    }

    #[\ReturnTypeWillChange]
    public function current() {
        return $this->array[$this->position];
    }

    #[\ReturnTypeWillChange]
    public function key() {
        return $this->position;
    }

    public function next(): void {
        ++$this->position;
    }

    public function valid(): bool {
        return isset($this->array[$this->position]);
    }
}