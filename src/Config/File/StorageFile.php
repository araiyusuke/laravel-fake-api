<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

use Illuminate\Support\Facades\Storage;
use Exception;

class StorageFile implements File {

    private const DEFAULT_CONFIG_FILE_NAME = "api-config.yml";
    private const DEFAULT_CONFIG_FILE_FOLDER_PATH = "./fakeapi/";
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

        $file = Storage::disk('local')
            ->get($this->path);

        return $this->loadYmlFile($file);
    }

    private function loadYmlFile($file): array
    {
        return spyc_load_file($file);
    }

    public function isExists(string $filePath): bool
    {
        return Storage::exists($filePath) === true;
    }

}