<?php
use PHPUnit\Framework\TestCase;
use Craft;
use craft\enums\CmsEdition;

final class ExampleUnitTest extends TestCase
{
    public function test_check_craft_edition(): void
    {
        $this->assertEquals(CmsEdition::Pro, Craft::$app->edition);
    }
}