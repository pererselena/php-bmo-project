<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$id = htmlentities($_POST["id"]) ?? null;
$title = htmlentities($_POST["title"]) ?? null;
$category = htmlentities($_POST["category"]) ?? null;
$text = htmlentities($_POST["text"]) ?? null;
$image = htmlentities($_POST["image"]) ?? null;
$owner = htmlentities($_POST["owner"]) ?? null;
$action = htmlentities($_POST["action"]) ?? null;

$params = [$title, $category, $text, $image, $owner, $id];

if ($action == "delete") {
    $db = connectToDatabase($dsn);
    $sql = "DELETE FROM Object WHERE id=?;";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $url = "admin.php";
    header("Location: $url");
}

$db = connectToDatabase($dsn);
$sql = <<<EOD
UPDATE Object
SET
    title = ?,
    category = ?,
    text = ?,
    image = ?,
    owner = ?
WHERE
    id = ?
;
EOD;
$stmt = $db->prepare($sql);
$stmt->execute($params);

$url = "admin.php";
header("Location: $url");
