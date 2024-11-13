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
    public function test_can_access_articles_in_section(): void
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

    public function test_can_access_all_articles_with_url(): void
    {
        $client = new Client([
            'base_uri' =>  App::env('PRIMARY_SITE_URL'),
            'timeout'  => 10.0,
            'verify' => false
        ]);

        $sites = Craft::$app->getSites()->getAllSites();
        
        foreach ($sites as $site) {
            if($site->handle == 'default') {
                continue;
            }

            $entries = Entry::find()->site($site->handle)->all();
            foreach ($entries as $entry) {
                $route = $entry->getUrl();
                if($route == null) {
                    continue;
                }

                $response = $client->request('GET', $route);
                
                $this->assertEquals(200, $response->getStatusCode());
                $this->assertNotNull($entry->title);
            }
        }
    }
    
}
