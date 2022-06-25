<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Parser;

interface Parser {
        
    public function getVersion(): string;

    public function getAPiPaths(): array;

    public function getApiPathInfo(string $method, array $path): PathInfo;

}