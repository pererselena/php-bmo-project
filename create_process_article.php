<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$id = htmlentities($_POST["id"]) ?? null;
$title = htmlentities($_POST["title"]) ?? null;
$category = htmlentities($_POST["category"]) ?? null;
$content = htmlentities($_POST["content"]) ?? null;
$author = htmlentities($_POST["author"]) ?? null;
$pubdate = htmlentities($_POST["pubdate"]) ?? null;

$params = [$id, $category, $title, $content, $author, $pubdate];

$db = connectToDatabase($dsn);
$sql ="INSERT INTO Article VALUES (?, ?, ?, ?, ?, ?);";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$url = "admin.php";
header("Location: $url");
