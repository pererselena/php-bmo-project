<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$title = "Hem" . $baseTitle;
$db = connectToDatabase($dsn);
$sql = "SELECT * FROM Object WHERE title = 'Begravningstårta'";
$stmt = $db->prepare($sql);
$stmt->execute();
$object = $stmt->fetchAll(PDO::FETCH_ASSOC);



require __DIR__ . "/view/header.php";
require __DIR__ . "/view/index.php";
require __DIR__ . "/view/footer.php";
