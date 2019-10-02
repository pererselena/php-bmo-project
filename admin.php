<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

$title = "Admin" . $baseTitle;

$db = connectToDatabase($dsn);

$sql = "SELECT * FROM Article";
$stmt = $db->prepare($sql);
$stmt->execute();

$adminArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM Object";
$stmt = $db->prepare($sql);
$stmt->execute();

$adminObjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
// test

$pageReference = $_GET["page"] ?? "status";

$base = basename(__FILE__, ".php");

$pages = [
    "login" => [
        "title" => "Login",
        "file" => __DIR__ . "/login/login.php",
    ],
    "login-process" => [
        "title" => null,
        "file" => __DIR__ . "/login/login-process.php",
    ],
    "logout-process" => [
        "title" => null,
        "file" => __DIR__ . "/login/logout-process.php",
    ],
    "status" => [
        "title" => "Status",
        "file" => __DIR__ . "/login/status.php",
    ],
    "protected" => [
        "title" => "Protected page",
        "file" => __DIR__ . "/login/protected.php",
    ],
];
// Get the current page from the $pages collection, if it matches
$page = $pages[$pageReference] ?? null;

// end test

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/admin.php";
require __DIR__ . "/view/footer.php";
