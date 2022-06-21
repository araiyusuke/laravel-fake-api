<?php

namespace Araiyusuke\FakeApi\Collections;

use Illuminate\Support\Facades\Storage;

class Path {

    public string $uri;
    public string $method;
    public int $statusCode;
    public ?string $file;
    public bool $auth;
    public array $requests;
    public ?string $responseJson;
    public ?string $bearerToken;    
    public ?string $layout;
    private const YML_KEY_STATUS_CODE = "statusCode";
    private const YML_KEY_RESPONSE_JSON_TEMP_FILE = "responseJsonFile";
    private const YML_KEY_AUTH = "auth";
    private const YML_KEY_REQUEST = "requests";
    private const YML_KEY_RESPONSE_JSON = "responseJson";
    private const YML_KEY_BEARER_TOKEN = "bearer_token";
    private const YML_KEY_LAYOUT = "layout";

    function __construct(
        string $uri,
        string $method,
        int $statusCode,
        ?string $responseJsonFile,
        ?bool $auth,
        ?array $requestBody,
        ?string $responseJson,
        ?string $bearerToken,
        ?string $layout,
        ?int $repeatCount,
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