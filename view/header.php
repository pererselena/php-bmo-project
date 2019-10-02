<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BMO</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
    <link rel='shortcut icon' href='img/logo/icon1.png' />
</head>

<body>
    <header class="site-header">
        <img src="img/logo/logo.png" alt="ett dött träd" />
        <h1 class="site-title">BMO</h1>
        <form class="site-slogan" action="search.php#search" method="get">
            <input type="text" name="search" value="" placeholder="Search">
        </form>
    </header>
    <nav class="navbar">
        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/index.php")) {
            ?> class="selected" <?php
}
        ?> href="index.php">Hem</a>


        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/about.php")) {
            ?> class="selected" <?php
}
        ?> href="about.php#om">Om</a>

        <div class="dropdown">
        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/article.php")) {
            ?> class="selected" <?php
}
        ?> href="article.php#artiklar">Artiklar</a>
            <div class="dropdown-content">
<?php $articles = getAllArticles($dsn);
foreach ($articles as $key => $value) : ?>
                <a href="article.php?page=<?= $value["id"] ?>#artiklar"><?= $value["title"] ?></a>
            <?php endforeach;?>
            <a href="article.php?page=alla#artiklar">Alla objekt</a>
            </div>
        </div>

        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/maggy.php")) {
            ?> class="selected" <?php
}
        ?> href="maggy.php#maggy">Begravningsseder</a>

        <div class="dropdown">
        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/object.php")) {
            ?> class="selected" <?php
}
        ?> href="object.php?page=alla#objekt">Objekt</a>
            <div class="dropdown-content">
<?php
$objects = getAllObjects($dsn);
foreach ($objects as $key => $value) : ?>
                    <a href="object.php?page=<?= $key ?>#objekt"><?= $value["title"] ?></a>
                <?php endforeach; ?>
                <a href="object.php?page=alla#objekt">Alla objekt</a>
            </div>
        </div>


        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/pictures.php")) {
            ?> class="selected" <?php
}
        ?> href="pictures.php#bilder">Bilder</a>

        <a <?php if (strpos($_SERVER['SCRIPT_NAME'], "/admin.php")) {
            ?> class="selected" <?php
}
        ?> href="admin.php#admin">Admin</a>
    </nav>
