<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$id = htmlentities($_POST["id"]) ?? null;
$category = htmlentities($_POST["category"]) ?? null;
$title = htmlentities($_POST["title"]) ?? null;
// Not satisfied with this solution. But since we have pictures in the Article
// This is the current solution.
$content = $_POST["content"] ?? null;
// Try to remove Javascript at least.
$content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
$author = htmlentities($_POST["author"]) ?? null;
$pubdate = htmlentities($_POST["pubdate"]) ?? null;
$action = htmlentities($_POST["action"]) ?? null;


$params = [$category, $title, $content, $author, $pubdate, $id];

if ($action == "delete") {
    $db = connectToDatabase($dsn);
    $sql = "DELETE FROM Article WHERE id=?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $url = "admin.php";
    header("Location: $url");
}

$db = connectToDatabase($dsn);
$sql = <<<EOD
UPDATE Article
SET
    category = ?,
    title = ?,
    content = ?,
    author = ?,
    pubdate = ?
WHERE
    id = ?
;
EOD;
$stmt = $db->prepare($sql);
$stmt->execute($params);

$url = "admin.php";
header("Location: $url");
