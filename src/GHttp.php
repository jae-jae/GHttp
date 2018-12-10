<?php

/**
 * 基于GuzzleHttp的简单版Http客户端。 Simple Http client base on GuzzleHttp
 *
 * @Author: Jaeger <JaegerCode@gmail.com>
 *
 * @Version V1.0
 */

namespace Jaeger;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Closure;

class GHttp
{
    private static $client = null;

    public static function getClient(array $config = [])
    {
        if(self::$client == null){
            self::$client = new Client($config);
        }
        return self::$client;
    }

    /**
     * @param $url
     * @param array $args
     * @param array $otherArgs
     * @return string
     */
    public static function get($url,$args = null,$otherArgs = [])
    {
        is_string($args) && parse_str($args,$args);
        $args = array_merge([
            'verify' => false,
            'query' => $args,
            'headers' => [
                'referer' => $url,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ],$otherArgs);
        $client = self::getClient();
        $response = $client->request('GET', $url,$args);
        return (string)$response->getBody();
    }

    public static function getJson($url, $args = null, $otherArgs = [])
    {
        $data = self::get($url, $args , $otherArgs);
        return json_decode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $url
     * @param array $args
     * @param array $otherArgs
     * @return string
     */
    public static function post($url,$args = null,$otherArgs = [])
    {
        is_string($args) && parse_str($args,$args);
        $args = array_merge([
            'verify' => false,
            'form_params' => $args,
            'headers' => [
                'referer' => $url,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ],$otherArgs);
        $client = self::getClient();
        $response = $client->request('Post', $url,$args);
        return (string)$response->getBody();
    }

    /**
     * @param $url
     * @param null $raw
     * @param array $otherArgs
     * @return string
     */
    public static function postRaw($url, $raw = null, $otherArgs = [])
    {
        is_array($raw) && $raw = json_encode($raw);
        $args = array_merge([
            'verify' => false,
            'body' => $raw,
            'headers' => [
                'referer' => $url,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ],$otherArgs);
        $client = self::getClient();
        $response = $client->request('Post', $url,$args);
        return (string)$response->getBody();
    }

    /**
     * @param $url
     * @param null $args
     * @param array $otherArgs
     * @return string
     */
    public static function postJson($url, $args = null, $otherArgs = [])
    {
        is_string($args) && parse_str($args,$args);
        $args = array_merge([
            'verify' => false,
            'json' => $args,
            'headers' => [
                'referer' => $url,
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ],$otherArgs);
        $client = self::getClient();
        $response = $client->request('Post', $url,$args);
        return (string)$response->getBody();
    }

    /**
     * @param $url
     * @param $filePath
     * @param null $args
     * @param array $otherArgs
     * @return string
     */
    public static function download($url,$filePath,$args = null,$otherArgs = [])
    {
        $otherArgs = array_merge($otherArgs,[
            'sink' => $filePath,
        ]);
        return self::get($url,$args,$otherArgs);
    }

    /**
     * @param $urls
     * @return MultiRequest
     */
    public static function multiRequest($urls)
    {
//        is_string($args) && parse_str($args,$args);
//        $args = array_merge([
//            'verify' => false,
//            'query' => $args,
//            'headers' => [
//                'referer' => $url,
//                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
//            ]
//        ],$otherArgs);
        $client = self::getClient();
//        $response = $client->request('GET', $url,$args);
//        return (string)$response->getBody();
/*        $response = $client->request('POST','http://httpbin.org/post', [
            'form_params' => [
                'field_name' => 'abc',
                'other_field' => '123',
                'nested_field' => [
                    'nested' => 'hello'
                ]
            ]
        ]);
        print_r((string)$response->getBody());die();*/


/*        $requests = function ($urls) use($client){
            foreach ($urls as $url) {
//                yield new Request('GET', $url);
                yield new Request('POST',$url,[
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'User-Agent' => 'hjhj'
                ],http_build_query([
                    'xxx' => 'aaa',
                    'ccc' => 'sss'
                ], '', '&'));
            }
        };

        $pool = new Pool($client, $requests($urls), [
            'concurrency' => 2,
            'fulfilled' => $success,
            'rejected' => $error,
        ]);

        $promise = $pool->promise();
        $promise->wait();*/

        return MultiRequest::newRequest($client)->urls($urls);
    }
}