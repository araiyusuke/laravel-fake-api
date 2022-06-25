<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Parser;

use Araiyusuke\FakeApi\Config\Collections\PathCollection;
use Araiyusuke\FakeApi\Config\File\File;

abstract class AbstractParser
{

    public const YML_KEY_VERSION = "fakeapi";
    
    public const YML_KEY_PATHS = "paths";
    
    public const YML_KEY_LAYOUT = "layout";

    abstract protected function getPaths(): PathCollection;

    abstract protected function getVersion(): string;

    abstract protected function getLayout(): array;

    abstract static protected function createFromFile(File $file): self;

    public function isValid(): bool {
        return true;
    }
}