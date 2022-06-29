<?php

namespace Tests\Unit;

use Tests\TestCase;

use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Config\Parser\YmlParser;
use Mockery;

class YmlParserTest extends TestCase
{
    private const dummyFileName = "api-config.yml";
    private const dummyPath = "/application/app/Library/araiyusuke/laravel-fake-api/tests/";
    private const dummyFilePath = self::dummyPath . self::dummyFileName;

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_存在しないキーの場合は例外が発生する()
    {

        $file = file_get_contents(self::dummyFilePath);
        $configs = spyc_load_file($file);

        // StorageFileクラスのloadメソッドが呼ばれて、戻り値が$configと同値になることを期待する
        $strageFile = Mockery::mock('Araiyusuke\FakeApi\Config\File\StorageFile');

        $strageFile
            ->shouldReceive('load')
            ->once()
            ->andReturn($configs);

        YmlParser::createFromFile($strageFile);
    }

    public function test_正しいレイアウト情報を取得できる()
    {
        $strageFile = Mockery::mock('Araiyusuke\FakeApi\Config\File\StorageFile');

        $strageFile
            ->shouldReceive('load')
            ->once()
            ->andReturn($this->expectedConfig());

        $res = YmlParser::createFromFile($strageFile)->getAllLayouts();
        $success = $res['success'];
        $arr = json_decode($success, true);
        $this->assertSame(200, $arr["code"]); 
        $this->assertSame("ok", $arr["message"]); 
        $this->assertSame("%data%", $arr["data"][0]); 

    }

    public function test_正しいYMLファイルのバージョンを取得できる()
    {

        // StorageFileクラスのloadメソッドが呼ばれて、戻り値が$configと同値になることを期待する
        $strageFile = Mockery::mock('Araiyusuke\FakeApi\Config\File\StorageFile');

        $strageFile
            ->shouldReceive('load')
            ->once()
            ->andReturn($this->expectedConfig());

        $res = YmlParser::createFromFile($strageFile);
        $this->assertSame("1.0.0", $res->getVersion());    
    }

    static function expectedPath(): Path
    {
        return new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile: 'test.json',
            responseJson: '{"id": "id"}',
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
            bearerToken: null,
            layout: null,
        );
    }
    private function expectedConfig(): array
    {
        $file = file_get_contents(self::dummyFilePath);
        return spyc_load_file($file);
    }
}