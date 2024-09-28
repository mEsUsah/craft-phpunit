# Craft PHPUnit setup
A simple PHPUnit setup for Craft CMS

## Setup
Run the setup script in the project root of your project:
```bash
wget -O - https://raw.githubusercontent.com/mEsUsah/craft-phpunit/refs/heads/master/setup.sh | bash
```

## Run example tests
### Modify Example
If you run Craft SOLO, change line 10 in tests/Unit/ExampleUnitTest.php to:
```php
$this->assertEquals(CmsEdition::Solo, Craft::$app->edition);
```

### Run tests
Run the example tests:
```bash
php ./vendor/bin/phpunit
```