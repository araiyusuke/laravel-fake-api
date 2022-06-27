<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Config\File\StorageFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class StorageFileTest extends TestCase
{

    private const dummyFileName = "api-config.yml";
    private const dummyPath = "/application/app/Library/araiyusuke/laravel-fake-api/tests/";
    private const dummy = self::dummyPath . self::dummyFileName;

    public function test_ファイルがある場合は配列データを取得できる()
    {
        $dummyFile = file_get_contents(self::dummy);
        $expected = spyc_load_file($dummyFile);

        Storage::shouldReceive('disk->get')
            ->andReturn($dummyFile);

        Storage::shouldReceive('exists')
            ->andReturn(true);

        $file = new StorageFile();
        $values = $file->load();

        $this->assertEquals($expected, $values);
    }

    public function test_ファイルが存在しない場合は例外が発生する()
    {

        $this->expectException(Exception::class);

        Storage::shouldReceive('exists')
            ->andReturn(false);

        $file = new StorageFile();
        $file->load();
    }
}