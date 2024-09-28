<?php
/*
    Written by Stanley Skarshaug 2024.09.29
    https://www.haxor.no
*/

use PHPUnit\Framework\TestCase;
use mesusah\crafthaxor\services\ArticlesService;

final class HaxorArticleServiceTest extends TestCase
{
    public function test_can_get_all_articles(): void
    {
        $articlesService = new ArticlesService();
        $articles = $articlesService->getAll();

        $this->assertIsArray($articles);
        $this->assertTrue(count($articles) > 0);
    }
}