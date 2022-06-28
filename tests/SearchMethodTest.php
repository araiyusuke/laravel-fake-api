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
            $this->assertSame("name", $match->getMethod());
            $this->assertSame(null, $match->getArg());
        }
    }

    public function test_メソッドの引数を取得する() 
    {
        $subject = "{'number' : '%rand_randomNumber(4)%'}";
        $searcher = new SearchMethod(SearchMethodType::cases(), $subject);
        foreach($searcher->matchAll() as $match) {
            $this->assertSame("randomNumber", $match->getMethod());
            var_dump($match->getArg());
            $this->assertSame(4, $match->getArg());
        }
    }
}