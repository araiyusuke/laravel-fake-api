<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Araiyusuke\FakeApi\Collections\Path;
use Araiyusuke\FakeApi\Parser\AbstractParser;
use Araiyusuke\FakeApi\Settings\SettingManager;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;

use Araiyusuke\FakeApi\Response\Response;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchReplaceMethod;

class RouteManager {
    
    public function __construct(
        private AbstractParser $parser, 
        private Response $response
    ){}

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

    private function registRequestValidationRule(Request $request, array $rules) {
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
    
            $this->registRequestValidationRule(request: $request, rules:  $path->requestBody);

            $searchMethodReplace = new SearchReplaceMethod(
                new DefaultFakerMethod(
                    SettingManager::getInstance()->getLang()
                )
            );

            $responseJson = $searchMethodReplace->perform($path->getResponseJson());

            return $this->response->generator(
                $path->statusCode,
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
        if ($this->parser->isValid()) {
            foreach($this->parser->getPaths() as $path) {
                $this->registRoute("/$path->uri",$path->method, $this->createAction($path), $path->auth);
            }
        }
    }
}