<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

interface File {    
    public function load(string $filePath);
    public function isValid(string $filePath): bool;
}