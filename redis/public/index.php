<?php

declare(strict_types=1);

require_once __DIR__ . "/../app/bootstrap.php";

use App\Database\PostgresConnection;
use App\Models\Article;
use App\Models\Comment;

function benchmark(callable $func, int $iterations): float {
    $start = microtime(true);
    for ($i = 0; $i < $iterations; $i++) {
        $func();
    }
    $end = microtime(true);
    return ($end - $start) / $iterations;
}

$article = new Article();
$comment = new Comment();

$articleIds = PostgresConnection::getInstance()->query("SELECT id FROM articles")->fetchAll(PDO::FETCH_COLUMN, 0);
$countArticles = count($articleIds);

if ($countArticles === 0) {
    die("No articles found in database. Please run seeders first.");
}

$testAmount = 100;

echo "<h2>Redis Caching Performance Benchmark</h2>";

echo "<h3>Testing direct database access</h3>";

$directArticleTime = benchmark(function() use ($article, $articleIds, $countArticles) {
    $articleId = $articleIds[rand(0, $countArticles - 1)];
    $article->find($articleId);
}, $testAmount);

echo "Average time for searching $testAmount articles directly: ";
echo round($directArticleTime * 1000, 2) . " ms<br>";

// Comments without cache
$directCommentTime = benchmark(function() use ($comment, $articleIds, $countArticles) {
    $articleId = $articleIds[rand(0, $countArticles - 1)];
    $comment->find($articleId);
}, $testAmount);

echo "Average time for searching $testAmount comments directly: ";
echo round($directCommentTime * 1000, 2) . " ms<br>";

echo "<h3>Testing Redis-cached access</h3>";

$cachedArticleTime = benchmark(function() use ($article, $articleIds, $countArticles) {
    $articleId = $articleIds[rand(0, $countArticles - 1)];
    $article->findCached($articleId);
}, $testAmount);

echo "Average time for searching $testAmount articles with Redis: ";
echo round($cachedArticleTime * 1000, 2) . " ms<br>";

$cachedCommentTime = benchmark(function() use ($comment, $articleIds, $countArticles) {
    $articleId = $articleIds[rand(0, $countArticles - 1)];
    $comment->findCached($articleId);
}, $testAmount);

echo "Average time for searching $testAmount comments with Redis: ";
echo round($cachedCommentTime * 1000, 2) . " ms<br>";

echo "<h3>Performance Improvement</h3>";
$articleImprovement = $directArticleTime / $cachedArticleTime;
$commentImprovement = $directCommentTime / $cachedCommentTime;

echo "Articles: Redis is " . round($articleImprovement, 1) . "x faster than direct DB access<br>";
echo "Comments: Redis is " . round($commentImprovement, 1) . "x faster than direct DB access<br>";