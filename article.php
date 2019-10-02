<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";
$db = connectToDatabase($dsn);
$sql = "SELECT * FROM Article WHERE category = 'article'";
$stmt = $db->prepare($sql);
$stmt->execute();
$dbArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
$articles = [];

//Läser in alla artiklar i en key value array.
//Lagrar title värdet som key och
foreach ($dbArray as $value) {
    $articles[$value["id"]][$value["title"]] = $value;
    //$articles[$value["title"]] = $value;
}


$title = "Article" . $baseTitle;

$pageReference = $_GET["page"] ?? "alla";

$pages = [];
/*
* Läser alla artiklar från databasen och skapar giltiga multipages.
* Men använder oss ej av .php filer för multipages utan löser det enbart i view filen.
*/
// Skapar en tom array som ska innehålla alla artiklar.
$pages["alla"]["content"] = [];
foreach ($articles as $key => $value) {
    $pages[$key]["title"] = $key;
    $pages[$key]["content"] = $value;
    $pages["alla"]["title"] = "Alla Objekt";
    $pages["alla"]["content"] = array_merge($pages["alla"]["content"], $value);
}


$page = $pages[$pageReference] ?? null;


require __DIR__ . "/view/header.php";
require __DIR__ . "/view/article.php";
require __DIR__ . "/view/footer.php";
