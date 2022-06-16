<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Faker\Factory as FakerFactory; 

class YmlApiException extends Exception{}

class FakerApiCreate {

    private const  DEFAULT_CONFIG_FILE_NAME = "api-config.yml";

    private $yml;

    private function getPaths() {
        return $this->yml['YmlApi']['paths'];
    }

    function __construct($settingFile = Self::DEFAULT_CONFIG_FILE_NAME){
        $this->load(yml: $settingFile);
    }

    private function load(string $yml) { 
        $file = Storage::disk('local')->get($yml);
        $this->yml = spyc_load_file($file);
    }

    private function convert(string $contents, string $model): string {
        $model = new $model;
        $faker = FakerFactory::create('ja_JP');
        $result = str_replace("%id%", "5", $contents);
        $result = str_replace("%rand_name%", $faker->name, $result);
        return str_replace("%rand_safeEmail%", $faker->safeEmail, $result);
    }

    private function createResponse(int $statusCode, string $body) {
        return response($body, $statusCode)
             ->header('Content-Type', 'application/json');
    }
    
    private function registValidation(Request $request, array $rules) {
        $request->validate($rules);
    }

   

    public function registFakeRouter() {
     
        foreach ($this->getPaths() as $path) {

            $path = new FakerApiPath($path);

            $closure = function (Request $request) use ($path) {

                // if ( guard($token = $path->bearerToken ) ) {
                //     return;
                // }



                $token = $request->bearerToken();


                $this->registValidation(request: $request, rules:  $path->requests);
                return $this->createResponse(
                    statusCode: $path->statusCode,
                    body: $this->convert(contents: $path->responseJson, model: $path->model)
                );
            };

            $this->registRoute(path: "/$path->name", type: RouterType::Get, closure: $closure, auth: $path->auth);
        }
    }

    public function registRoute(string $path, RouterType $type,  $closure, bool $auth = false) {
        Route::match([$type->value], $path,  $closure)
                ->middleware( $auth ? 'auth:sanctum' : null);
    }
}

function guard(?string $value): bool {
    return $value === null;
}