<?php

namespace Araiyusuke\FakeApi;

use Illuminate\Support\Facades\Storage;

class FakerApiPath {

public $path;
public $method;
public $statusCode;
public $file;
public $model;
public $auth;
public $requests;
public $responseJson;
public ?string $bearerToken;

function __construct($array) {
    $this->name = $array['name'];
    $this->method = $array['method'];
    $this->statusCode = $array['status_code'];
    $this->file = $array['response_json_temp_file'];
    $this->model = $array['model'];
    $this->responseJson = $array['response_json'];
    $this->auth = $array['auth'] ?? false;
    $this->requests = $array['requests'];
    $this->bearerToken = $array['bearer_token'] ?? null;
}

public function loadJsonFile() {
    return Storage::disk('local')->get($this->file);
}

}