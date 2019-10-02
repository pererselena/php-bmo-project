<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$title = "Search" . $baseTitle;
// Get search from GET string
$presearch = $_GET['search'] ?? null;

$search = "%" . $presearch . "%";

$db = connectToDatabase($dsn);


$sql = <<<EOD
SELECT
    *
FROM Article
WHERE
    category LIKE ? OR
    title LIKE ? OR
    content LIKE ? OR
    author LIKE ? OR
    pubdate LIKE ?
;
EOD;

$stmt = $db->prepare($sql);
$stmt->execute([$search, $search, $search, $search, $search]);


$searchArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = <<<EOD
SELECT
    *
FROM Object
WHERE
    title LIKE ? OR
    category LIKE ? OR
    text LIKE ? OR
    image LIKE ? OR
    owner LIKE ?
;
EOD;

$stmt = $db->prepare($sql);
$stmt->execute([$search, $search, $search, $search, $search]);
$searchObjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/search.php";
require __DIR__ . "/view/footer.php";
