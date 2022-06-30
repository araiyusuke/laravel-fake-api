<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Config\File\StorageFile;
use Araiyusuke\FakeApi\Exceptions\FileNotFoundException;
use Araiyusuke\FakeApi\Exceptions\InvalidConfigException;

class PathTest extends TestCase
{
    // public function test_存在しないメソッドが指定された場合は例外が発生する()
    // {
    //     $this->expectException(InvalidConfigException::class);
    //     $notExistMethod = "xxxxxxxxxxxxxxxx";

    //     new Path(
    //         uri: "/demo/me",
    //         method: $notExistMethod,
    //         statusCode: 201,
    //         response: "{test: 'test'}",
    //         requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
    //     );
    // }

    // public function test_レスポンスのJSONが複数指定されていたら例外が発生する()
    // {
    //     $this->expectException(InvalidConfigException::class);

    //     new Path(
    //         uri: "/demo/me",
    //         method: "get",
    //         statusCode: 201,
    //         response: "{test: 'test'}",
    //         requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
    //     );
    // }

    public function test_指定したJSONファイルが取得できる()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            response: '{"id" : 1}',
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

        $res = json_decode($path->getResponse(), true);
        $expected = array('id' => 1);
        $this->assertEquals($expected, $res);
    }

    // public function test_存在しないレスポンスJSONファイルを設定した時は例外が発生する()
    // {
    //     $this->expectException(FileNotFoundException::class);

    //     $notExistJSonFilePath = "/fakeapi/xxxxxxx.json";

    //     new Path(
    //         uri: "/demo/me",
    //         method: "get",
    //         statusCode: 201,
    //         requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
    //     );

    // }

    public function test_ステータスコードを取得する()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            response: "{test: 'test'}",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

        $this->assertEquals(201, $path->getStatusCode());
    }

    public function test_リクエストメソッドを取得する()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            response: "{test: 'test'}",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

        $this->assertEquals("get", $path->getMethod());
    }

    // public function test_レスポンス用のJSONが指定されていない場合は例外が発生する()
    // {
        
    //     $this->expectException(InvalidConfigException::class);

    //     new Path(
    //         uri: "/demo/me",
    //         method: "get",
    //         statusCode: 201,
    //         response: null,
    //         requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
    //     );
    // }
}