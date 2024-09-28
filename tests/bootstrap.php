<?php
use Dotenv\Dotenv;
use craft\helpers\App;

// Set path constants
define('CRAFT_BASE_PATH', dirname(__DIR__));
define('CRAFT_VENDOR_PATH', CRAFT_BASE_PATH.'/vendor');

// Load Composer's autoloader
require_once CRAFT_VENDOR_PATH.'/autoload.php';

// Load dotenv
$dotenv = Dotenv::createImmutable(CRAFT_BASE_PATH);
$dotenv->load();

// Load Craft
define('CRAFT_ENVIRONMENT', 'testing');
require CRAFT_VENDOR_PATH.'/craftcms/cms/bootstrap/console.php';