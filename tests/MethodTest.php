<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Config\Collections\Method;
use Araiyusuke\FakeApi\Exceptions\InvalidMethodException;
use Mockery;


class MethodTest extends TestCase
{
    public function test_存在しないメソッドを指定された場合は例外が発生する()
    {
        $this->expectException(InvalidMethodException::class);
        $method = new Method("not_exists_method");

        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);
        $method->call($fakerMethod);   
    }


    public function test_引数が存在しない場合はfalseを返す()
    {
        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);
        $fakerMethod->shouldReceive('name');

        $method = new Method("name");
        $this->assertEquals($method->isArg(), false);
    }

    public function test_引数が存在する場合はtrueを返す()
    {
        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);
        $fakerMethod->shouldReceive('name');

        $method = new Method("name", array("param"));
        $this->assertEquals($method->isArg(), true);
    }

    public function test_単体のメソッドで引数があるパターンは正しく呼び出される()
    {
        
        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);

        $fakerMethod
            ->shouldReceive('realText')
            ->with(10)
            ->once();

        $method = new Method("realText", array(10));
        $method->call($fakerMethod);
    }

    public function test_単体のメソッドで引数が2つあるパターンは正しく呼び出される()
    {
        
        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);

        $fakerMethod
            ->shouldReceive('randomElement')
            ->with(array("apple", "orange"))
            ->once();

        $method = new Method("randomElement", array("apple", "orange"));
        $method->call($fakerMethod);
    }

    public function test_単体のメソッドが正しく呼び出される()
    {
        $fakerMethod = Mockery::mock(DefaultFakerMethod::class);
        $fakerMethod->shouldReceive('name')->once();

        $method = new Method("name");
        $method->call($fakerMethod);
    }
}