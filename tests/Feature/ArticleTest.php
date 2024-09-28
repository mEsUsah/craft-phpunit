<?php
/*
    Written by Stanley Skarshaug 2024.09.29
    https://www.haxor.no
*/

use PHPUnit\Framework\TestCase;
use craft\elements\Entry;
use craft\helpers\App;
use GuzzleHttp\Client;

final class ArticlesTest extends TestCase
{    
    public function test_can_access_all_articles(): void
    {
        $client = new Client([
            'base_uri' =>  App::env('PRIMARY_SITE_URL'),
            'timeout'  => 4.0,
        ]);
        
        $entries = Entry::find()
            ->section(["articles"])
            ->all();

        foreach ($entries as $entry) {
            $route = $entry->getUrl();
            $response = $client->request('GET', $route);
            
            $this->assertEquals(200, $response->getStatusCode());
        }
    }
}