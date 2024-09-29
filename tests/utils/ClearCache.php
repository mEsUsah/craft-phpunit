<?php
namespace Tests\utils;

use craft\utilities\ClearCaches;
use craft\helpers\FileHelper;
use craft\cache\FileCache;

class ClearCache
{
    public static function run(): void
    {
        $cacheOptions = ClearCaches::cacheOptions();
        foreach ($cacheOptions as $cacheOption) {
            if(is_string($cacheOption['action'])){
                FileHelper::clearDirectory($cacheOption['action']);
            }
            if(is_array($cacheOption['action'])){
                foreach ($cacheOption['action'] as $action) {
                    if($action instanceof FileCache){
                        FileHelper::clearDirectory($action->cachePath);
                    }
                }
            }
        }
    }
}