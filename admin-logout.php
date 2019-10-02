<h2>Förstör session</h2>

<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";
sessionDestroy();

$title = "Admin logout" . $baseTitle;

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/admin.php";
require __DIR__ . "/view/footer.php";
