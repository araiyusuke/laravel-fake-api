<?php

namespace Tests\Unit;

use Tests\TestCase;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Faker\DefaultFakerMethod;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodReplace;

class SearchMethodReplaceTest extends TestCase
{
    public function test_変換メソッドが呼ばれている()
    {
        $path = new Path(
            uri: "/demo/me",
            method: "get",
            statusCode: 201,
            response: "{
                'name': '%rand_name%',
                'boolean': '%rand_boolean%',
                'boolean': '%rand_company%',
                'prefecture': '%rand_prefecture%',
                'time': '%rand_time%',
                'day': '%rand_day%',
                'kanaName': '%rand_kanaName%',
                'month': '%rand_month%',
                'year': '%rand_year%',
                'latitude': '%rand_latitude%',
                'longitude': '%rand_longitude%',
                'realText': '%rand_realText(100)%',
                'country': '%rand_country%',
                'url': '%rand_url%',
                'ipv4': '%rand_ipv4%',
                'isbn13': '%rand_isbn13%',
                'password': '%rand_password%',
                'city': '%rand_city%',
                'randomNumber': '%rand_randomNumber(5)%',
                'rand_randomElement': '%rand_randomElement(090,080)%',
                'phoneNumber': '%rand_phoneNumber%',\
                'creditCardNumber': '%rand_creditCardNumber%',
                'postcode': '%rand_postcode%',
                'uuid': '%rand_uuid%',
                'isbn10': '%rand_isbn10%',
                'numberBetween': '%rand_numberBetween(0,10)%',
                'word': '%rand_word%',
                'lastKanaName': '%rand_lastKanaName%',
                'firstKanaName': '%rand_firstKanaName%',
                'streetAddress': '%rand_streetAddress%',
                'email': '%rand_email%',
            }",
        );

        $fakerMethod = $this->createMock(DefaultFakerMethod::class);

        /// FakerMethoで定義されているメソッドをループ
        foreach(DefaultFakerMethod::methods() as $method) {

            /// メソッドが呼ばれているか検証する
            $fakerMethod
                ->expects($this->once())
                ->method($method);
        }

        // 呼ばれているか確認するためモックを引数に渡す
        $searchMethodReplace = new SearchMethodReplace($fakerMethod);
        // 実行
        $searchMethodReplace->perform($path->getResponse());
    }
}