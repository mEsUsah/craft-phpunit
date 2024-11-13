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
            'timeout'  => 10.0, // Wait for image transforms
            'verify' => false
        ]);

        $sites = Craft::$app->getSites()->getAllSites();
        $entries = [];
        
        // Loop through all sites and get all entries
        foreach ($sites as $site) {
            if($site->handle == 'default') {
                continue;
            }

            $siteEntries = Entry::find()->site($site->handle)->all();
            array_push($entries, ...$siteEntries);
        }

        // Loop through all entries and create a request for each
        $requests = function () use ($entries) {
            foreach ($entries as $entry) {
                if($entry->getUrl() == null) {
                    continue;
                }
                yield new Request('HEAD', $entry->getUrl());
            }
        };

        // Send all requests concurrently
        $pool = new Pool($client, $requests(), [
            'concurrency' => 10,  // Adjust this number based on your server's capacity
            'fulfilled' => function ($response, $index) {
                $this->assertEquals(200, $response->getStatusCode());
            },
            'rejected' => function ($exception, $index) {
                $this->fail("Request failed: " . $exception->getMessage());
            },
        ]);

        $pool->promise()->wait();
    }
}
