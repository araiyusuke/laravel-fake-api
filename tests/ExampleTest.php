<?php

namespace Araiyusuke\FakeApi;

use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\MockInterface;
use Araiyusuke\FakeApi\DefaultFile;

class ExampleTest extends TestCase
{
    /**
     * 基本的なテスト例
     *
     * @return void
     */
    public function test_basic_test()
    {

        $tmdbServiceMock = Mockery::mock('overload:Araiyusuke\FakeApi\DefaultFile');
        $tmdbServiceMock->shouldReceive('getPath')
                         ->once()
                         ->andReturn("test");

        $fileManager = new DefaultFileManager;
    
        $this->assertEquals("test", $fileManager->getPath());
    }
}