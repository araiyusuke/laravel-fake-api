<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\FileManager;

interface FileManager {

    public function getPath(): string;

    public function loadConfigFromFile(string $path): array;

    public function isExistConfigFile(string $fileName): bool;

}