<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

interface File {

    public function getPath(): string;

    public function loadConfigFromFile(string $path): array;

    public function isExistConfigFile(string $fileName): bool;

}