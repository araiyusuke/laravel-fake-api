<?php


declare(strict_types=1);

namespace Araiyusuke\FakeApi\Response\Json;
/**
 * レスポンスJSONのタグを検索するクラスはこれを実装する。
 */
interface Search
{
    /**
     * レスポンスJSONにあるタグを検索する
     *
     * @param array $type 検索パターン
     * @param string $subject 検索のターゲット
     */
    public function __construct(array $type, string $subject);
}