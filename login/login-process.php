<?php

$user = $_POST["user"] ?? null;
$password = $_POST["password"] ?? null;

$aUser = $users[$user] ?? null;
$aPassword = $users[$user]["password"] ?? null;
if ($aUser && password_verify($password, $aPassword)) {
    $_SESSION["user"] = $user;
    $_SESSION["name"] = $aUser["name"];
    $_SESSION["flashmessage"] = "Your login was successful!";
    header("Location: ?page=status");
    exit;
}
// Failed to login, redirect to login-page again.
$_SESSION["flashmessage"] = "You failed to login!";
header("Location: ?page=login");
