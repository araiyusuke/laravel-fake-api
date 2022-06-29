<?php
namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethod;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodType;

class SearchMethodTest extends TestCase
{
    public function test_メソッド名を取得する() 
    {
        $subject = "{'name' : '%rand_name%'}";
        $searcher = new SearchMethod(SearchMethodType::cases(), $subject);
        foreach($searcher->matchAll() as $match) {
            $method = $match->getMethod();
            $this->assertSame("name", $method->getName());
            $this->assertSame(null, $method->getArg());
        }
    }

    public function test_メソッドの引数を取得する() 
    {
        $subject = "{'number' : '%rand_randomNumber(4)%'}";
        $searcher = new SearchMethod(SearchMethodType::cases(), $subject);
        foreach($searcher->matchAll() as $match) {
            $method = $match->getMethod();
            $this->assertSame("randomNumber", $method->getName());
            $this->assertEquals(4, $method->getArg()[0]);
        }
    }
}