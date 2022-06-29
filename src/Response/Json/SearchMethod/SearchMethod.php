<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json\SearchMethod;

use Araiyusuke\FakeApi\Response\Json\Search;
use Araiyusuke\FakeApi\Config\Collections\Method;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodResult;
use Araiyusuke\FakeApi\Response\Json\SearchMethod\SearchMethodResultCollection;

/**
 * ターゲットの文字列から関数タグを抽出してコレクションに代入する
 */
class SearchMethod implements Search
{
   
    /**
     * Undocumented function
     *
     * @param MatchType[] $types
     * @param string $subject
     */
    public function __construct(private array $types, private string $subject)
    {
        $this->types = $types;
        $this->subject = $subject;
    }

    /**
     * 関数タグを見つけたらメソッドと引数とidをコレクションに追加。
     *
     * @return SearchMethodResultCollection
     */
    public function matchAll(): SearchMethodResultCollection 
    {

        $result = new SearchMethodResultCollection();

        foreach( $this->types as $type) { 

            $matchAll = $type->matchAll($this->subject);
            
            foreach ($matchAll as $match) {

                foreach($type->key() as $key => $value) {
                    $$value = $match[$key];
                }
                
                $method = new Method($method, $arg ?? null);
    
                $result->add(
                    new SearchMethodResult($search, $method, $id ?? null)
                );
            }
        }

        return $result;
    }
}