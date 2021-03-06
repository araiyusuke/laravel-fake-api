<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Araiyusuke\FakeApi\Response\Response;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Config\Collections\PathCollection;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\searchMethodReplace;

class Routing {
    
    public function __construct(
        private PathCollection $paths, 
        private Response $response
    ){

    }

    /**
     * ルートを登録する
     *
     * @param string $uri
     * @param string $method
     * @param [type] $closure
     * @param boolean $auth
     * @return void
     */
    public function registRoute(string $uri, string $method,  $closure, bool $auth = false): void
    {
        Route::match([$method], $uri,  $closure)
                ->middleware( $auth ? 'auth:sanctum' : null);
    }

    /**
     * リクエストメソッドのvalidationルールを登録する。
     *
     * @param Request $request
     * @param array $rules
     * @return void
     */
    private function registValidationRule(Request $request, array $rules) {
        $request->validate($rules);
    }

    /**
     * ルートに登録するクロージャを作成する
     *
     * @param Path $path
     * @return Closure
     */
    private function createAction(Path $path): Closure {

        return function(Request $request) use ($path) {

            $token = $request->bearerToken();

            if (is_null($path->getRequestBody() === false)) {
                $this->registValidationRule(request: $request, rules:  $path->getRequestBody());
            }
    
            $searchMethodReplace = new SearchMethodReplace(
                new DefaultFakerMethod(
                    FakerApi::$lang
                )
            );

            $responseJson = $searchMethodReplace->perform($path->getResponse());

            return $this->response->generator(
                $path->getStatusCode(),
                $responseJson
            );
        };
    }

    /**
     * パーサーで受け取ったデータを元にルートを登録する
     *
     * @return void
     */
    public function regist(): void {
        foreach($this->paths as $path) {
            $this->registRoute("/{$path->getUri()}", $path->getMethod(), $this->createAction($path), $path->getAuth());
        }        
    }
}