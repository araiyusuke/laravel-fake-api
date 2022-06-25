<?php

namespace Araiyusuke\FakeApi\Config\Collections;

use Illuminate\Support\Facades\Storage;

class Path {

    function __construct(
        private string $uri,
        private string $method,
        private int $statusCode,
        private ?string $responseJsonFile,
        private ?bool $auth,
        private ?array $requestBody,
        private ?string $responseJson,
        private ?string $bearerToken,
        private ?string $layout,
        private ?int $repeatCount,
        ) 
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->statusCode = $statusCode;
        $this->responseJsonFile = $responseJsonFile ?? null;
        $this->responseJson = $responseJson ?? null;
        $this->auth = $auth ?? false;
        $this->requestBody = $requestBody;
        $this->bearerToken = $bearerToken ?? null;
        $this->layout = $layout ?? null;
        $this->repeatCount = $repeatCount ?? null;
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
     * クライアントから送られてきたリクエスト
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


    /**
     * クライアントに返すレスポンス
     *
     * @return string
     */
    public function getResponseJson(): string 
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