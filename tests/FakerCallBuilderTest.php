<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Araiyusuke\FakeApi\Faker\FakerCallBuilder;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Exceptions\InvalidConfigException;

class FakerCallBuilderTest extends TestCase
{
    public function test_存在しないメソッドが指定された場合は例外が発生する()
    {

        // $this->expectException(InvalidConfigException::class);

        $this->faker = new DefaultFakerMethod;
        $builder = new FakerCallBuilder;
        $builder->setInstance($this->faker);
        $method = Mockery::mock('Araiyusuke\FakeApi\Config\Collections\Method');
        $method->shouldReceive('call')->once();
        $builder->setMethod($method);
        $builder->call();
    }
}