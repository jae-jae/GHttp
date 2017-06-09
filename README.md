# GHttp
基于GuzzleHttp的简单版Http客户端。 Simple Http client base on GuzzleHttp

## 安装

```
composer require jaeger/g-http
```

## 用法

```php

use Jaeger\GHttp;

$rt = GHttp::get('https://www.baidu.com/s?wd=QueryList');

//or

$rt = GHttp::get('https://www.baidu.com/s',[
    'wd' => 'QueryList'
]);

//opt

$rt = GHttp::get('https://www.baidu.com/s',[
    'wd' => 'QueryList'
],[
    'headers' => [
        'referer' => 'https://baidu.com',
        'User-Agent' => 'Mozilla/5.0 (Windows NTChrome/58.0.3029.110 Safari/537.36',
        'Cookie' => 'cookie xxx'
    ]
]);

$rt = GHttp::post('https://www.posttestserver.com/post.php',[
    'name' => 'QueryList',
    'password' => 'ql'
]);


GHttp::download('http://sw.bos.baidu.com/setup.exe','./path/to/xx.exe');

```