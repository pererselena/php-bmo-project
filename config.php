<?php

error_reporting(-1);              // Report all type of errors
ini_set("display_errors", 1);     // Display all errors

$baseTitle = " | htmlphp";

// Start the named session,
// the name is based on the path to this file.

$name = preg_replace("/[^a-z\d]/i", "", __DIR__);
session_name($name);
session_start();


$styles = [
    "default" => "css/style.css",
    "light" => "css/style.css",
    "dark" => "css/dark.css",
];

$users = [
    "doe" => [
        "name"=> "John/Jane Doe",
        "password" => password_hash("doe", PASSWORD_DEFAULT)
    ],
    "admin" => [
        "name"=> "All Mighty Administrator",
        "password" => password_hash("admin", PASSWORD_DEFAULT)
    ],
];



//DSN bmo2
$fileName = __DIR__ . "/db/bmo2.sqlite";
$dsn = "sqlite:$fileName";
