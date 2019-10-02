<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$id = htmlentities($_POST["id"]) ?? null;
$title = htmlentities($_POST["title"]) ?? null;
$category = htmlentities($_POST["category"]) ?? null;
$text = htmlentities($_POST["text"]) ?? null;
$image = htmlentities($_POST["image"]) ?? null;
$owner = htmlentities($_POST["owner"]) ?? null;

$params = [$id, $title, $category, $text, $image, $owner];

$db = connectToDatabase($dsn);
$sql ="INSERT INTO Object VALUES (?, ?, ?, ?, ?, ?);";

$stmt = $db->prepare($sql);
$stmt->execute($params);

$url = "admin.php";
header("Location: $url");
