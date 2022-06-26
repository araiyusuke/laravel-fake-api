<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

use Illuminate\Support\Facades\Storage;
use Exception;

class TestFile implements File {

    private const DEFAULT_CONFIG_FILE_NAME = "api-config.yml";
 
    private const DEFAULT_CONFIG_FILE_FOLDER_PATH = "/application/app/Library/araiyusuke/laravel-fake-api/tests/";
    private const PATH = self::DEFAULT_CONFIG_FILE_FOLDER_PATH . self::DEFAULT_CONFIG_FILE_NAME;

    public function __construct(string $path = self::PATH)
    {
        $this->path = $path;
    }

    public function load(): array 
    {
        
        // 設定ファイルが存在しない場合は例外
        if ($this->isExists($this->path) === false) {
            throw new Exception("設定ファイルが存在しません");
        }
        
        $file = file_get_contents($this->path);

        return spyc_load_file($file);
    }

    public function isExists(string $filePath): bool
    {
        return file_exists($filePath);
    }

}