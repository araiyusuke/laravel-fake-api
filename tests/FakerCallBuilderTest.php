<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Faker\FakerCallBuilder;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Config\Collections\Method;
use Mockery;

class FakerCallBuilderTest extends TestCase
{
    public function test_存在しないメソッドが指定された場合は例外が発生する()
    {
        $this->faker = new DefaultFakerMethod;
        $builder = new FakerCallBuilder;
        $builder->setInstance($this->faker);
        $method = Mockery::mock('Araiyusuke\FakeApi\Config\Collections\Method');
        $method->shouldReceive('call')->once();
        $builder->setMethod($method);
        $builder->call();
    }
}