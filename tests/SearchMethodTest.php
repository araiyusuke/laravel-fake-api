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
}