<?php
use PHPUnit\Framework\TestCase;
use craft\helpers\App;
use GuzzleHttp\Client;

final class ExampleFeatureTest extends TestCase
{    
    public function test_can_access_homepage(): void
    {
        $client = new Client([
            'base_uri' =>  App::env('PRIMARY_SITE_URL'),
            'timeout'  => 2.0,
        ]);
        
        $response = $client->request('GET', '/');
        
        $this->assertEquals(200, $response->getStatusCode());
    }
}