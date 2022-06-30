<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Parser;

use Araiyusuke\FakeApi\Config\Collections\PathCollection;
use Araiyusuke\FakeApi\Config\File\File;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Exceptions\FileNotFoundException;
use Exception;

abstract class Parser
{

    /**
     * ファイルアクセス
     *
     * @var File
     */
    protected File $file;

    abstract protected function getPaths(): PathCollection;

    abstract protected function getVersion(): string;

    abstract protected function getAllLayouts(): array;

    abstract static protected function createFromFile(File $file, string $name): self;

    public final function __construct(array $config, File $file)
    {
        $this->config = $config;
        $this->file = $file;
    }

    protected const VERSION = "fakeapi";
    
    protected const PATHS = "paths";
    
    protected const LAYOUT = "layout";

    protected const METHOD = "method";

    protected const URI = "uri";

    protected const AUTH = "auth";

    protected const BEARER_TOKEN = "bearerToken";

    protected const STATUS_CODE = "statusCode";
    
    protected const REPEAT_COUNT = "repeatCount";

    protected const REQUEST_BODY = "requestBody";

    protected const RESPONSE_JSON_FILE = "responseJsonFile";

    protected const RESPONSE_JSON = "responseJson";

    protected const PATH_KEYS = array(
        self::URI,
        self::AUTH,
        self::BEARER_TOKEN,
        self::REPEAT_COUNT,
        self::REQUEST_BODY,
        self::RESPONSE_JSON,
        self::METHOD,
        self::STATUS_CODE,
        self::RESPONSE_JSON_FILE
    );

    protected const REQUIRED_KEYS = array(
        self::URI,
        self::METHOD,
        self::STATUS_CODE
    );

    public function isValidRequired(array $array): bool
    {
        return $this->array_keys_exist($array, self::REQUIRED_KEYS);
    }

    public function createPath(array $array): Path 
    {
        if ($this->isValidRequired($array)) {

            $response = $array[self::RESPONSE_JSON];

            if (!is_null($array[self::RESPONSE_JSON_FILE] ?? null)) {
                if ($this->file->isValid($array[self::RESPONSE_JSON_FILE])) {
                    $response = $this->file->loadResponseFile($array[self::RESPONSE_JSON_FILE]);
                }    
            }
          
            if (is_null($response)) {
                throw new FileNotFoundException("レスポンスで返すためのJSONファイルがパスに存在しません");
            }

            if ($this->isValidMethods($array[self::METHOD]) === false) {
                throw new InvalidConfigException("不正なリクエストメソッドです");
            }

            return new Path(
                uri: $array[self::URI],
                method: $array[self::METHOD],
                statusCode: $array[self::STATUS_CODE],
                response: $response ?? null,
                auth: $array[self::AUTH] ?? Path::DEFAULT_VALUE_AUTH,
                requestBody: $array[self::REQUEST_BODY] ?? null,
                bearerToken: $array[self::BEARER_TOKEN] ?? null,
                layout: $this->getLayoutFile($array[self::LAYOUT] ?? null),
                repeatCount: $array[self::REPEAT_COUNT] ?? Path::DEFAULT_VALUE_REPEAT_COUNT
            );
        } else {
            throw new Exception("存在しないキーがあります。");
        }
    }

    function array_keys_exist( array $array, $keys ) {
        $count = 0;
        if ( ! is_array( $keys ) ) {
            $keys = func_get_args();
            array_shift( $keys );
        }
        foreach ( $keys as $key ) {
            if ( isset( $array[$key] ) || array_key_exists( $key, $array ) ) {
                $count ++;
            } else {
                throw new Exception("{$key}がセットされてません");
            }
        }
    
        return count( $keys ) === $count;
    }

    /**
     * レイアウトファイルがあれば返す。なければnul
     *
     * @param string|null $layoutFile
     * @return string|null
     */
    private function getLayoutFile(?string $layoutFile): ?string
    {
        if (is_null($layoutFile)) { return null; }

        /// レイアウトリストに対象のレイアウトがあれば
        if  (array_key_exists( $layoutFile,  $this->getAllLayouts())) {
            /// そのレイアウトファイル名を返す
            return $this->getAllLayouts()[$layoutFile];
        } else {
            throw new FileNotFoundException("Layoutファイルが存在しません");
        }
    }
}