<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

interface File {

    public function __construct(string $path);

    public function load(): array;

    public function isValid(string $fileName): bool;

}