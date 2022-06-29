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

        $strageFile = Mockery::mock('Araiyusuke\FakeApi\Config\File\StorageFile');
        $strageFile
            ->shouldReceive('load')
            ->once()
            ->andReturn($configs);

        YmlParser::createFromFile($strageFile);
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

    // public function test_test()
    // {
    //     $this->expectException(Exception::class);

    //     $parser = YmlParser::createFromFile(new TestFile);
    //     FakerApi::setLang("ja_JP");
    //     $paths = $parser->getPaths();
    //     $this->assertEquals(1,1);

    //     // $this->assertEquals($paths->current(), self::expectedPath());
    // }
}