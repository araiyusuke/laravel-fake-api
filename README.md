# laravel-fake-api

## yml形式のファイルを使ってLaravelにAPIのモック環境を構築するライブラリ

- Fakerのメソッドを使ってランダムな値を返せます。
- レイアウト機能を使えば共通のレイアウトを返すことができます。
- LaravelのValidationルールが使えます。
- authをtrueにすることでBearer認証を有効にできます。
- repeatCountを指定すれば連続の値を出力できます。

### LaravelのRoute定義ファイルで初期化してください。

```php

try {
    
    $file = new StorageFile();
    $parser = YmlParser::createFromFile($file, "./fakeapi/api-config.yml");

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

### api-config

APIの設計はyml形式で行う。

```yml

fakeapi: 1.0.0

layout:

  success: |
    { 
      "code": "200",
      "message": "ok",
      "data": [
        %data%
      ]
    }

  error: |
    {
      "code": "203",
      "message": "error",
      "data": %data%
    }

paths:
  /demo/me:
    get:
      description: 単体のユーザー情報を返す
      statusCode: 201
      layout: success
      auth: false
      responseJson: |
        {
          "numberBetween": %rand_numberBetween(3,4)_1%,
          "id": "%id%",
          "word": "%rand_word%",
          "isbn10": "%rand_isbn10%",
          "uuid": "%rand_uuid%",
          "prefecture": "%rand_prefecture%",
          "ipv4": "%rand_ipv4%",
          "year": "%rand_year%",
          "day": "%rand_day%",
          "month": "%rand_month%",
          "time": "%rand_time%",
          "kanaName": "%rand_kanaName%",
          "firstKanaName": "%rand_firstKanaName%",
          "lastKanaName": "%rand_lastKanaName%",
          "company": "%rand_company%",
          "latitude": %rand_latitude%,
          "longitude": %rand_longitude%,
          "realText": "%rand_realText(50)%",
          "boolean": %rand_boolean_1%,
          "boolean": %rand_boolean_2%,
          "isbn13": "%rand_isbn13%",
          "mail": "%rand_email_1%",
          "name" : "%rand_name%",
          "password": "%rand_password_1%",
          "address": "%rand_city% %rand_streetAddress_1% %rand_postcode% ",
          "phoneNumber": "%rand_phoneNumber_1%",
          "country": "%rand_country%",
          "url" : "%rand_url_11%",
          "city": "%rand_city%",
          "gender": {
            "hoge": "%rand_randomElement(男,女)%",
          },
          "mobile_number": "%rand_randomElement(090,080)_1% - %rand_randomNumber(4)_1% - %rand_randomNumber(4)_1%",
          "mobile_number": "%rand_randomElement(090,080)_2% - %rand_randomNumber(4)_2% - %rand_randomNumber(4)_2%",
          "rand_number": %rand_randomNumber(9)%,
          "pet": "%rand_randomElement(犬, 猫)%",
          "id": %rand_randomElement(1, 2)%,
          "creditCardNumber": "%rand_creditCardNumber%",
        }
      requestBody: 
        name: required|max:5
        mail: required|max:20

    post:
      description: 単体のユーザー情報を返す
      statusCode: 200
      auth: false
      responseJson: |
        {
          "id": "%id%",
          "mail": "%rand_safeEmail%",
          "name" : "%rand_name%"
        }
      requestBody: 
          name: required|max:5
          mail: required|max:20
  
  /demo/mqtt:
    get:
      description: mqttを単体で取得
      statusCode: 200
      responseJson: |
        {
          "id": "%id%",
          "mail": "%rand_safeEmail%",
          "name" : "%rand_name%"
        }
      requestBody:
          id: required
  
  /demo/goal:
    get:
      description: 単体のユーザー情報を返す
      method: GET
      layout: error
      statusCode: 200
      repeatCount: 5
      responseJson: |
        {
          "incrementId": %increment_id%,
          "goal": {
            "goalType": "%rand_randomElement(LOSE, GAIN)%",
            "startDate": "2018-06-13",
            "startWeight": %randomFloat(3,0,10)%,
            "weight": %randomFloat(3,0,10)%,
            "weightThreshold": %randomFloat(3,0,10)%
          }
        }
      requestBody: 
          user-id: required
          goal-type: required


```


### suffixを使えば、同じメソッド名で異なるランダムな値を返すことができます

メソッド名_1, メソッド名_2, メソッド名_3

### Generators Method 

|  method name | random value |
| ------------- | ------------- |
| rand_name  | 漢字のフルネーム  |
| rand_firstName  | 名前  |
| lastName  | 名字  |
| rand_kanaName  | カタカナのフルネーム  |
| rand_firstKanaName  | カタカナの名前  |
| rand_lastKanaName  | カタカナの名字  |
| rand_country  | 国 |
| rand_prefecture  | 県 |
| rand_year  | 年 |
| rand_month  | 月 |
| rand_day  | 日 |
| rand_time  | 時刻 |
| rand_mail  | メール |
| rand_boolean  | Boolean |
| rand_realText(int digit)  | ランダムな文字列 |
| rand_company  | 会社名 |
| rand_city  | 市 |
| rand_postcode  | 郵便番号 |
| rand_streetAddress  | 番地 |
| rand_latitude  | 緯度 |
| rand_longitude  | 経度 |
| rand_password  | パスワード |
| rand_phoneNumber  | 携帯番号 or 家の電話 |
| rand_url  | URL |
| rand_ipv4  | IPアドレス |
| rand_isbn10  | International Standard Book Number(10) |
| rand_isbn13  | International Standard Book Number(13) |
| rand_creditCardNumber  | クレジットカード |
| increment_id  | repeatCountを指定した時に連番のIDが出力されます |
| rand_numberBetween(int,int)  | 引数に指定した範囲からランダムな数字を返します |
| rand_randomFloat(少数桁数, 最小値, 最大値)  | ランダムな浮動小数点数を一つ返す |
| rand_randomElement(A,...B)  | 引数に指定した値からランダムで一つ返す |

Created by araiyusuke
