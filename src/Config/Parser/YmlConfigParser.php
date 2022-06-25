<?php

declare(strict_types=1);

namespace Araiyusuke\FakeApi\Config\Parser;

use Araiyusuke\FakeApi\Config\Collections\PathCollection;
use Araiyusuke\FakeApi\Config\Collections\Path;
use Araiyusuke\FakeApi\Config\File\File;
class YmlConfigParser extends AbstractParser {

    static $instance = null;

    private final function __construct(array $config)
    {
        $this->config = $config;
    }

    public static function createFromFile(File $manager): self
    {
        $config = $manager->loadConfigFromFile($manager->getPath());
        return YmlConfigParser::create($config);
    }

    public static function create(array $config)
    {
        return static::$instance ?? static::$instance = new static($config);
    }

    public function getVersion(): string
    {
        return $this->config[self::YML_KEY_VERSION];
    }

    public function getLayout(): array
    {
        return $this->config[self::YML_KEY_LAYOUT];
    }

    /**
     * Pathリストを返す
     *
     * @return PathCollection
     */
    public function getPaths(): PathCollection 
    {

        $collection = new PathCollection;

        foreach ($this->config[static::YML_KEY_PATHS] as $uri => $targetPath) {

            foreach($targetPath as $method => $pathInfo) {

                extract($pathInfo);

                $path = new Path(
                    uri: $uri,
                    method: $method,
                    statusCode: $statusCode,
                    responseJsonFile: $responseJsonFile ?? null,
                    responseJson: $responseJson ?? null,
                    auth: $auth,
                    requestBody: $requestBody ?? null,
                    bearerToken: $bearerToken ?? null,
                    layout: $this->getLayout()[$layout] ?? null,
                    repeatCount: $repeatCount ?? null
                );

                $collection->set($path);
            }
        }

        return $collection;
    }
}