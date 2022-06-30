<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

use Illuminate\Support\Facades\Storage;
use Exception;

/**
 * LaravelのStorageファイルを扱う
 */
class StorageFile implements File 
{

    public function load(string $filePath): array 
    {
        if ($this->isValid($filePath) === false) {
            throw new Exception("設定ファイルが存在しません");
        }

        $file = Storage::disk('local')->get($filePath);
        
        return spyc_load_file($file);
    }

    public function isValid(string $filePath): bool
    {
        return Storage::exists($filePath) === true;
    }

}