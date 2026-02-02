<?php

namespace Tests;

use Jaeger\GHttp;
use PHPUnit\Framework\TestCase;

class GHttpTest extends TestCase
{
    public function testGet()
    {
        $html = GHttp::get('https://www.example.com');
        $this->assertStringContainsString('Example Domain', $html);
    }

    public function testPost()
    {
        // Use a test API endpoint
        $response = GHttp::postJson('https://httpbin.org/post', ['foo' => 'bar']);
        $this->assertStringContainsString('"foo": "bar"', $response);
    }

    public function testMultiRequest()
    {
        $urls = [
            'https://www.example.com',
            'https://httpbin.org/get'
        ];
        
        $results = [];
        
        GHttp::multiRequest($urls)
            ->success(function($response, $index) use (&$results) {
                $results[$index] = (string)$response->getBody();
            })
            ->error(function($reason, $index) {
                // handle error
            })
            ->get();
            
        $this->assertCount(2, $results);
    }
}
