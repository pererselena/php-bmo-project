<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$currentPage = intval($_GET['gallery'] ?? 1);

$title = "Bilder" . $baseTitle;

$db = connectToDatabase($dsn);

$sql = "SELECT title, image FROM Object";
$stmt = $db->prepare($sql);
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

$gallery = [];
$counter = 0;
while ($images != null) {
    $gallery[$counter][0] = array_pop($images);
    $gallery[$counter][1] = array_pop($images);
    $gallery[$counter][2] = array_pop($images);
    $gallery[$counter][3] = array_pop($images);
    $counter += 1;
}

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/pictures.php";
require __DIR__ . "/view/footer.php";
