<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

interface File {

    public function load(): array;

    public function isExists(string $fileName): bool;

}