<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";
$db = connectToDatabase($dsn);
$sql = "SELECT * FROM Object";
$stmt = $db->prepare($sql);
$stmt->execute();
$dbArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
$objects = [];

foreach ($dbArray as $value) {
    $objects[$value["category"]][$value["id"]] = $value;
}

$title = "Objekt" . $baseTitle;

$pageReference = $_GET["page"] ?? "Begravningskonfekt";
/*
För att kunna lägga till och ta bort objekt måste detta arbetas om.
Vi måste "skapa" $pages ifrån vad vi läser in ifrån databasen.
Alternativt arbeta om hela konceptet.
*/

// Skapar en tom pages array.
$pages = [];
/*
* Läser alla objects från databasen och skapar giltiga multipages.
* Men använder oss ej av .php filer för multipages utan löser det enbart i view filen.

*/
$pages["alla"]["content"] = [];
foreach ($objects as $key => $value) {
    $pages[$key]["title"] = $key;
    $pages[$key]["content"] = $value;
    $pages["alla"]["title"] = "Alla Objekt";
    $pages["alla"]["content"] = array_merge($pages["alla"]["content"], $value);
}


$page = $pages[$pageReference] ?? null;

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/object.php";
require __DIR__ . "/view/footer.php";
