<?php

namespace Araiyusuke\FakeApi;

use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Araiyusuke\FakeApi\FakerApi;
use Araiyusuke\FakeApi\DefaultFile;
use Araiyusuke\FakeApi\Config\File\TestFile;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Config\Parser\YmlParser;
use Araiyusuke\FakeApi\Config\Collections\PathCollection;

class YmlParserTest extends TestCase
{
    /**
     * 基本的なテスト例
     *
     * @return void
     */
    // public function test_basic_test()
    // {

    //     $tmdbServiceMock = Mockery::mock('overload:Araiyusuke\FakeApi\DefaultFile');
    //     $tmdbServiceMock->shouldReceive('getPath')
    //                      ->once()
    //                      ->andReturn("test");

    //     $fileManager = new DefaultFileManager;
    
    //     $this->assertEquals("test", $fileManager->getPath());
    // }

    static function expectedPath(): Path
    {
        return new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            responseJsonFile:  "friends1.json",
            responseJson: "{\"id\": \"id\"}",
            auth: false,
            requestBody: array('name' => "required|max:5", 'mail' => 'required|max:20'),
            bearerToken: null,
            layout: null,
            repeatCount: null
        );
    }

    public function test_test()
    {
        $parser = YmlParser::createFromFile(new TestFile);
        FakerApi::setLang("ja_JP");
        $paths = $parser->getPaths();
        $this->assertEquals($paths->current(), self::expectedPath());

    }
}