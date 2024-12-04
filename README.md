# PHPUnit setup for Craft CMS
A simple PHPUnit setup for Craft CMS.

## Setup:
Run this one-liner in your project root to add the basic files and directories:
* NB! If you use DDev, you must run the script inside the container.
```bash
wget -O - https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/setup.sh | bash
```
For a more in-depth desription on the setup and how to get started with testing Craft CMS with PHPUnit, read [this article on my blog](https://haxor.no/en/article/testing-craft-cms).

## Example tests:
This repo contains some example tests, that can be used for inspiration.

### Modify Example
If you run Craft Solo, you must change line 10 in tests/Unit/ExampleUnitTest.php to:
```php
$this->assertEquals(CmsEdition::Solo, Craft::$app->edition);
```

### Run tests
Run the tests with this command:
```bash
php ./vendor/bin/phpunit
```

## Utils
If you need to use the utility classes in this repo, you must add the "Tests" root namespace to your composer.json

```json
{
    ...
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    ...
}
```
Once added, you must run composer update, to make it work.

```bash
composer update
```

### ClearCache utility
You can then use the the ClearChache utility class.
```php
<?php
namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Tests\utils\ClearCache;

final class ExampleTest extends TestCase
{    
    public function test_can_clear_cache(): void
    {
        ClearCache::run();
        $this->assertTrue(true);
    }
}
```
