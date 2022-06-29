<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Config\Collections\Method;
use Araiyusuke\FakeApi\Exceptions\InvalidMethodException;

class MethodTest extends TestCase
{
    public function test_存在しないメソッドを指定された場合は例外が発生する()
    {
        $this->expectException(InvalidMethodException::class);

        $method = new Method("not_exists_method");
        $fakerMethod = $this->createMock(DefaultFakerMethod::class);
        $method->call($fakerMethod);
    }
}