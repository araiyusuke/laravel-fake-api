<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Parser;

use Araiyusuke\FakeApi\Config\File\File;
use Araiyusuke\FakeApi\Config\Collections\PathCollection;

/**
 * YML形式のAPI作成のための設定ファイルを読み込む
 */
class YmlParser extends Parser {

  
    /**
     * Fileを実装したファイル読み込みクラスからインスタンスを生成する
     *
     * @param File $file
     * @return self
     */
    public static function createFromFile(File $file, string $name): self
    {
        $config = $file->load($name);
        return new self($config, $file);
    }

    /**
     * APIの設定ファイル
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->config[self::VERSION];
    }

    /**
     * 親のレイアウトファイルリスト
     *
     * @return array
     */
    public function getAllLayouts(): array
    {
        return $this->config[self::LAYOUT];
    }

    /**
     * Pathリストを返す
     *
     * @return PathCollection
     */
    public function getPaths(): PathCollection 
    {

        $collection = new PathCollection;

        foreach ($this->config[static::PATHS] as $uri => $paths) {

            foreach($paths as $method => $path) {

                $path = $path
                 + array(self::METHOD => $method)
                 + array(self::URI => $uri);
                 
                $collection->add($this->createPath($path));
            }
        }

        return $collection;
    }

     /**
     * リクエストメソッドの有効を確認する
     *
     * @return boolean
     */
    public function isValidMethods($method): bool
    {
        $methods = array('post', 'get', 'put', 'delete');
        return in_array($method, $methods);
    }
}