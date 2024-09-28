<?php
/*
    Written by Stanley Skarshaug 2024.09.29
    https://github.com/mEsUsah
    https://www.haxor.no
*/

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