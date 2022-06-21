<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Araiyusuke\FakeApi\Collections\Path;
use Araiyusuke\FakeApi\Parser\AbstractParser;
use Araiyusuke\FakeApi\Response\ResponseManager;
use Araiyusuke\FakeApi\Settings\SettingManager;
use Araiyusuke\FakeApi\Faker\FakerManager;

use Closure;

class RouteManager {
    
    public function __construct(
        private AbstractParser $parser, 
        private ResponseManager $response
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

            $faker = FakerManager::getInstance(
                SettingManager::getInstance()->getLang()
            );

            return $this->response->generator(
                statusCode: $path->statusCode,
                body: $faker->assign($path->getResponseJson())
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