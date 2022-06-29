<?php
namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethod;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodType;

class SearchMethodTypeTest extends TestCase
{
    public function test_ID付きの関数を抽出する正規表現が取得できる() 
    {
        $res = SearchMethodType::methodWithId;
        $this->assertSame("%rand_([a-zA-Z0-9]+)_(\d+)%", $res->getPattern());
    }

    public function test_関数を抽出する正規表現が取得できる() 
    {
        $res = SearchMethodType::method;
        $this->assertSame("%rand_([a-zA-Z0-9]+)%", $res->getPattern());
    }

    public function test_関数にマッチしたデータを取得できる() 
    {
        $subject = "{'name' : '%rand_name%'}";
        $searchType = SearchMethodType::method;
        $res = $searchType->matchAll($subject);
        $this->assertSame($res[0][1], "name");
    }

    public function test_関数と引数にマッチしたデータを取得できる() 
    {
        $subject = "{'name' : '%rand_name(1,3)%'}";
        $searchType = SearchMethodType::methodParameter;
        $res = $searchType->matchAll($subject);
        $this->assertSame($res[0][1], "name");
        $this->assertSame($res[0][2], "1,3");
    }

    public function test_関数とIDにマッチしたデータを取得できる() 
    {
        $subject = "{'name' : '%rand_name_2%'}";
        $searchType = SearchMethodType::methodWithId;
        $res = $searchType->matchAll($subject);
        $this->assertSame($res[0][1], "name");
        $this->assertSame($res[0][2], "2");
    }

}