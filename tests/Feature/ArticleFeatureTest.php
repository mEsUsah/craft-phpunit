<?php
/*
    Written by Stanley Skarshaug 2024.11.14
    https://www.haxor.no
*/
namespace tests\Feature;
use PHPUnit\Framework\TestCase;
use craft\elements\Entry;
use craft\helpers\App;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

final class ArticleFeatureTest extends TestCase
{    
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
            if(!$site->enabled) {
                continue;
            }
            $siteEntries = Entry::find()->site($site->handle)->all();
            array_push($entries, ...$siteEntries);
        }

        // Loop through all entries and create a request for each
        $requests = function () use ($entries) {
            foreach ($entries as $entry) {
                $url = $entry->getUrl();
                if($url == null) {
                    continue;
                }
                if(strpos($url, "@web") !== false) {
                    $url = str_replace("@web", "", $url);
                }
                yield new Request('HEAD', $url);
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
