<?php

namespace Araiyusuke\FakeApi\Config\Collections;

use Illuminate\Support\Facades\Storage;

class Path {

    private string $uri;
    private string $method;
    private int $statusCode;
    private string $responseJson;
    private ?bool $auth = false;
    private ?array $requestBody;
    private ?string $bearerToken;
    private ?string $layout;
    private int $repeatCount;

    public function __construct(
         string $uri,
         string $method,
         int $statusCode,
         ?string $responseJsonFile,
         ?bool $auth = false,
         ?array $requestBody,
         ?string $responseJson,
         ?string $bearerToken,
         ?string $layout,
         ?int $repeatCount,
    ) 
    {

        if (is_null($responseJsonFile ?? $responseJson)) {
            throw new Exception("レスポンスJSONは必須です。");
        }

        $this->uri = $uri;
        $this->method = $method;
        $this->statusCode = $statusCode;
        $this->responseJson = $responseJsonFile;
        $this->auth = $auth;
        $this->requestBody = $requestBody;
        $this->bearerToken = $bearerToken;
        $this->layout = $layout;
        $this->repeatCount = $repeatCount ?? 1;
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


    private static function loadLayout(?string $layoutFile): ?string
    {
        if (is_null($layoutFile)) { return null; }

        return $this->getLayout()[$layoutFile];
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

    public static function isNotSetJson(?string $json): bool
    {
        return is_null($json);
    }

    public function getResponseJson(?string $jsonFile, ?string $jsonStr): string
    {

        $responseJson = null;

        if (is_null($jsonFile) === false) {
            $responseJson = $this->jsonFile;
        }

        if (is_null($jsonStr) === false) {
            $responseJson = $this->jsonStr;
        }

        if (is_null($responseJson)) {
            throw new Exception("レスポンスJSONは必須です。");
        }

        return $responseJson;
    }

    private function methodCheck(): bool
    {
        $methods = array('post', 'get', 'put', 'delete');
        return in_array($this->method, $methods);
    }

    /**
     * クライアントに返すレスポンス
     *
     * @return string
     */
    public function getResponse(): string 
    {

        $result = "";

        foreach (range(0, $this->repeatCount) as $incrementId) {
            $separator = $incrementId !== 0 ? "," : "";
            $result .= $separator . str_replace("%increment_id%", $incrementId, $this->responseJson);        
        }
    
        return str_replace("%data%", $result, $this->layout);
    }
    
    public function loadJsonFile(): string 
    {
        return Storage::disk('local')->get($this->file);
    }
}