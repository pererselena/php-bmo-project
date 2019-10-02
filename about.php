<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$title = "About" . $baseTitle;


/*
* Läser ut en artikel från databasen. Från tabellen Article
*/
$db = connectToDatabase($dsn);

$sql = "SELECT * FROM Article WHERE category = 'about'";
$stmt = $db->prepare($sql);
$stmt->execute();

/*
* Om vi istället använder fetchAll får vi först gå igenom den första arrayen för
* att hitta våran/våra artiklar, användbart om vi har flera artiklar..
*/
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$output = $res["content"];
/*
* Läser ut en bild ifrån databasen. Från tabellen Object.
* Vi får ett filnamn som vi kan använda för att titta i img katalogen efter rätt
* bild av rätt storlek (Ska vi kopiera in enbart "rätt" storlek???)
*/
$sql = "SELECT * FROM Object WHERE title = 'Inbjudningsbrev Johan August Lång'";
$stmt = $db->prepare($sql);
$stmt->execute();

/*
* Tittar enbart i key "image" för att få ut filnamnet.
* Tittar enbart i key "text" för att få alt texten till bilden. Eller figurtext.
* Om vi istället använder fetchAll får vi först gå igenom den första arrayen för
* att hitta våra bilder, användbart om vi har flera bilder.
*/
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$image = $res["image"];
$imageText= $res["text"];

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/about.php";
require __DIR__ . "/view/footer.php";
