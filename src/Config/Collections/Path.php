<?php

namespace Araiyusuke\FakeApi\Config\Collections;

use Exception;
use Illuminate\Support\Facades\Storage;
use Araiyusuke\FakeApi\Exceptions\FileNotFoundException;
use Araiyusuke\FakeApi\Exceptions\InvalidConfigException;

class Path {

    const DEFAULT_VALUE_AUTH = false;
    const DEFAULT_VALUE_REPEAT_COUNT = 0;
    const Option = null;

    public function __construct(
        private string $uri,
        private string $method,
        private int $statusCode,
        private ?string $responseJsonFile = Path::Option,
        private bool $auth = self::DEFAULT_VALUE_AUTH,
        private ?array $requestBody = Path::Option,
        private ?string $responseJson = Path::Option,
        private ?string $bearerToken = Path::Option,
        private ?string $layout = Path::Option,
        private int $repeatCount = self::DEFAULT_VALUE_REPEAT_COUNT,
    ) 
    {

        if (is_null($responseJsonFile) && is_null($responseJson)) {
            throw new InvalidConfigException("レスポンスJSONは必須です。");
        }

        if (!is_null($responseJsonFile) && !is_null($responseJson)) {
            throw new InvalidConfigException("レスポンスのJSONが複数指定されています。");
        }

        if (!is_null($responseJsonFile) && $this->isValidPath($responseJsonFile) === false) {
            throw new FileNotFoundException("レスポンスで返すためのJSONファイルがパスに存在しません");
        }

        if ($this->isValidMethods($method) === false) {
            throw new InvalidConfigException(" '{$method}'は不正なリクエストメソッドです");
        }

    }

    /**
     * レスポンスのステータスコード
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * クライアントが送信するリクエストデータ
     *
     * @return array|null
     */
    public function getRequestBody(): ?array
    {
        return $this->requestBody;
    }

    /**
     * beareToken認証の有無
     *
     * @return boolean
     */
    public function getAuth(): bool 
    {
        return $this->auth;
    }

    /**
     * 接続先URI
     *
     * @return string
     */
    public function getUri(): string 
    {
        return $this->uri;
    }

    /**
     * リクエストメソッド
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    public function getResponseJson(): string
    {
        return $this->loadJsonFile();
    }

    /**
     * リクエストメソッドの有効を確認する
     *
     * @return boolean
     */
    private function isValidMethods(): bool
    {
        $methods = array('post', 'get', 'put', 'delete');
        return in_array($this->method, $methods);
    }

    /**
     * APIのActionで返すレスポンスの文字列を返す
     *
     * @return string
     */
    public function getResponse(): string 
    {

        $res = "";

        foreach (range(0, $this->repeatCount) as $incrementId) {
            $separator = $incrementId !== 0 ? "," : "";
            $res .= $separator . str_replace("%increment_id%", $incrementId, $this->responseJson);        
        }

        if ( is_null($this->layout)) {
            return $res;
        }
    
        return str_replace("%data%", $res, $this->layout);
    }
    
    private function isValidPath($filePath): bool 
    {
        return Storage::exists($filePath);
    }

    private function loadJsonFile(): string 
    {
        if ($this->isValidPath($this->responseJsonFile)) {
            return Storage::disk('local')->get($this->responseJsonFile);
        }
    }
}