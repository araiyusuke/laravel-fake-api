<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\File;

use Illuminate\Support\Facades\Storage;

class DefaultFile implements File {

    private  const DEFAULT_CONFIG_FILE_NAME = "api-config.yml";
    private  const DEFAULT_CONFIG_FILE_FOLDER_PATH = "./fakeapi/";
    private $path = self::DEFAULT_CONFIG_FILE_FOLDER_PATH . self::DEFAULT_CONFIG_FILE_NAME;

    public function getPath(): string {
        return $this->path;
    }

    public function loadConfigFromFile(string $path): array {
        static::isExistConfigFile($path);
        $file = Storage::disk('local')->get($path);
        return spyc_load_file($file);
    }

    public function isExistConfigFile(string $filePath):bool {
        return Storage::exists($filePath) === true;
    }

}