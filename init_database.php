<?php
require __DIR__ . "/config.php";
require __DIR__ . "/src/functions.php";

recreateDb();
header("Location: admin.php");
