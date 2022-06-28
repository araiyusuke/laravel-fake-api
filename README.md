# laravel-fake-api

## yml形式のファイルからAPIのモック環境をLaravelに構築するライブラリ


Created by araiyusuke


```php

try {
    $parser = YmlParser::createFromFile(new StorageFile);
    FakerApi::setLang("ja_JP");
    FakerApi::registRoute($parser->getPaths());
} catch (ConfigFileValidationErrorException $e) {
    foreach($e->getMessages() as $message) {
        print($message . "\n");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

```
