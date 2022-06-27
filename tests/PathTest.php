<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Config\File\StorageFile;
use Illuminate\Support\Facades\Storage;
use Exception;
use Araiyusuke\FakeApi\Config\Collections\Path;

class PathTest extends TestCase
{
    public function test_存在しないメソッドが指定された場合は例外が発生する()
    {
        $this->expectException(Exception::class);

        new Path(
            uri: "/demo/me",
            method: "fake_get",
            statusCode: 201,
            responseJsonFile: "/fakeapi/success.json",
            responseJson: "{test: 'test'}",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );
    }

    public function test_レスポンスのJSONが複数指定されていたら例外が発生する()
    {
        $this->expectException(Exception::class);

        new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: "/fakeapi/success.json",
            responseJson: "{test: 'test'}",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );
    }

    public function test_指定したJSONファイルが取得できる()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: "/fakeapi/success.json",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

        $res = json_decode($path->getResponseJson(), true);
        $expected = array('id' => 1);
        $this->assertEquals($expected, $res);
    }

    public function test_存在しないレスポンスJSONファイルを設定した時は例外が発生する()
    {
        $this->expectException(Exception::class);

        new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: "not_found.json",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

    }

    public function test_ステータスコードを取得する()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: null,
            responseJson: "{test: 'test'}",
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
            responseJsonFile: null,
            responseJson: "{test: 'test'}",
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );

        $this->assertEquals("get", $path->getMethod());
    }

    public function test_レスポンス用のJSONが指定されていない場合は例外が発生する()
    {
        
        $this->expectException(Exception::class);

        new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: null,
            responseJson: null,
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
        );
    }
}