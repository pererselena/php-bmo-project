<?php

function loadTime()
{
    $numFiles = count(get_included_files());
    $memoryUsed = memory_get_peak_usage(true);
    $loadTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];

    return "Time to load page: " . $loadTime . "\nFiles included: " .  $numFiles . "\nMemory used: " . $memoryUsed;
}



/**
 * Destroy a session, the session must be started.
 *
 * @return void
 */
function sessionDestroy()
{
    // Unset all of the session variables.
    $_SESSION = [];

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}

// Connect to database
function connectToDatabase($dsn)
{
    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>$dsn<br>";
        throw $e;
    }
    return $db;
}

/*
* Läser ut valda positioner or input (text, image, title och owner)
* Lägger dessa i en output sträng med HTML taggar för att visa texten i en p tag.
* Bilden i en img tag med en a tag för att kunna se bilden i full storlek.
* Avslutar med att lägga ägare av bilden i en p tag.
* Detta görs för alla index i arrayen $input.
*/
function printObjects($input)
{
    $output = "";
    foreach ($input as $index) {
        $output .= "<section class=\"objects\">";
        $output .= "<h3>{$index['title']}</h3>";
        $output .= "<figure>";
        $output .= "<a href=\"img/full-size/{$index['image']}\"><img class=\"floating-image\" src=\"img/250x250/{$index['image']}\" alt=\"{$index['title']}\"></a>";
        $output .= "<figcaption>Ägare: {$index["owner"]}</figcaption>";
        $output .= "</figure>";
        $output .= "<p>{$index["text"]}</p>";
        $output .= "<a href=\"admin.php?page=protected&type=objekt&id={$index["id"]}#admin\">Edit objekt</a>";
        $output .= "</section>";
    }
    return $output;
}

function printObject($input)
{
    $output = "";
    foreach ($input as $index) {
        $output .= "<section class=\"objects\">";
        $output .= "<h3>{$index['title']}</h3>";
        $output .= "<figure>";
        $output .= "<a href=\"img/full-size/{$index['image']}\"><img class=\"floating-image\" src=\"img/250x250/{$index['image']}\" alt=\"{$index['title']}\"></a>";
        $output .= "<figcaption>Ägare: {$index["owner"]}</figcaption>";
        $output .= "</figure>";
        $output .= "<p>{$index["text"]}</p>";
        $output .= "</section>";
    }
    return $output;
}

/*
*/
function printArticles($input)
{
    $output = "";
    foreach ($input as $index) {
        $output .="<h2>{$index["title"]}</h2>";
        $output .= "{$index["content"]}";
        $output .= "<p>{$index["author"]} publicerad {$index["pubdate"]}</p>";
        $output .= "<a href=\"admin.php?page=protected&type=article&id={$index["id"]}#admin\">Edit artikel</a>";
    }
    return $output;
}

function getAllArticles($dsn)
{
    $db = connectToDatabase($dsn);
    $sql = "SELECT id, title FROM Article WHERE category = 'article'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $dbArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $articles = [];
    
    return $dbArray;
    foreach ($dbArray as $value) {
        $articles[$value["id"]][$value["title"]] = $value;
    }

    foreach ($articles as $key => $value) {
        $articlesArray[$key]["id"] = $key;
        $articlesArray[$key]["title"] = $value["title"];
    }

    return $articlesArray;
}

function getAllObjects($dsn)
{
    $db = connectToDatabase($dsn);
    $sql = "SELECT * FROM Object";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $dbArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $objects = [];

    foreach ($dbArray as $value) {
        $objects[$value["category"]][$value["id"]] = $value;
    }
    // Skapar en tom pages array.
    $objectsArray = [];
    /*
    * Läser alla objects från databasen och skapar giltiga multipages.
    * Men använder oss ej av .php filer för multipages utan löser det enbart i view filen.

    */
    foreach ($objects as $key => $value) {
        $objectsArray[$key]["title"] = $key;
        $objectsArray[$key]["content"] = $value;
    }
    return $objectsArray;
}

function getFromDatabase($dsn, $type, $id)
{
    $db = connectToDatabase($dsn);
    if ($type == "article") {
        $sql = "SELECT * FROM Article WHERE id LIKE ?;";
    } else {
        $sql = "SELECT * FROM Object WHERE id LIKE ?;";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $dbArray = $stmt->fetch(PDO::FETCH_ASSOC);

    return $dbArray;
}


function printPictures($gallery, $currentPage)
{
    $output = "<p>";
    // Remove the link if we are on the first element in the array.
    if ($currentPage > 0) {
        $previous = $currentPage - 1;
        $output .= "<a class=\"gallery-menu\" href=\"pictures.php?gallery={$previous}#bilder\">Föregående</a>";
    }
    // Remove the link if we are on the last element in the array.
    if ($currentPage <= sizeof($gallery) - 2) {
        $next = $currentPage + 1;
        $output .= "<a class=\"gallery-menu\" href=\"pictures.php?gallery={$next}#bilder\">Nästa</a>";
    }
    $output .= "</p>";
    foreach ($gallery[$currentPage] as $index) {
        if ($index == null) {
            break;
        }
        $image = $index["image"];
        $alt = $index["title"];
        $output .= "<a href=\"img/full-size/{$image}\">";
        $output .= "<img class=\"gallery\" src=\"img/250/{$image}\" alt=\"{$alt}\">";
        $output .= "</a>";
    }
    return $output;
}

function showObjektForm($object)
{
    $id = htmlentities($object["id"]);
    $title = htmlentities($object["title"]);
    $cat = htmlentities($object["category"]);
    $text = htmlentities($object["text"]);
    $image = htmlentities($object["image"]);
    $owner = htmlentities($object["owner"]);

    $output ='<form class="objekt-form" method="post" action="update_process_object.php">';
    $output .= '<label>Id:';
    $output .= "<input value=\"{$id}\" type=\"number\" name=\"id\">";
    $output .= "<br>";
    $output .= '<label>Title:';
    $output .= "<input value=\"{$title}\" type=\"text\" name=\"title\">";
    $output .= "<br>";
    $output .= '<label>Category:';
    $output .= "<input value=\"{$cat}\" type=\"text\" name=\"category\">";
    $output .= "<br>";
    $output .= '<label>Text:';
    $output .= "<input value=\"{$text}\" type=\"text\" name=\"text\">";
    $output .= "<br>";
    $output .= '<label>Image:';
    $output .= "<input value=\"{$image}\" type=\"text\" name=\"image\">";
    $output .= "<br>";
    $output .= '<label>Owner:';
    $output .= "<input value=\"{$owner}\" type=\"text\" name=\"owner\">";
    $output .= "<br>";
    $output .= "<input type=\"submit\" value=\"update\" name=\"action\">";
    $output .= "<input type=\"submit\" value=\"delete\" name=\"action\">";
    $output .= "</form>";
    return $output;
}

function showObjektFormCreate()
{
    $output ='<form class="create_form_objekt" method="post" action="create_process_object.php">';
    $output .= '<label>Id:';
    $output .= "<input value=\"\" type=\"number\" name=\"id\">";
    $output .= "<br>";
    $output .= '<label>Title:';
    $output .= "<input value=\"\" type=\"text\" name=\"title\">";
    $output .= "<br>";
    $output .= '<label>Category:';
    $output .= "<input value=\"\" type=\"text\" name=\"category\">";
    $output .= "<br>";
    $output .= '<label>Text:';
    $output .= "<input value=\"\" type=\"text\" name=\"text\">";
    $output .= "<br>";
    $output .= '<label>Image:';
    $output .= "<input value=\"\" type=\"text\" name=\"image\">";
    $output .= "<br>";
    $output .= '<label>Owner:';
    $output .= "<input value=\"\" type=\"text\" name=\"owner\">";
    $output .= "<br>";
    $output .= "<input type=\"submit\" value=\"Skapa\">";
    $output .= "</form>";
    return $output;
}

function showArticleForm($article)
{
    $id = htmlentities($article["id"]);
    $title = htmlentities($article["title"]);
    $cat = htmlentities($article["category"]);
    $text = htmlentities($article["content"]);
    $author = htmlentities($article["author"]);
    $pubdate = htmlentities($article["pubdate"]);

    $output ='<form method="post" action="update_process_article.php">';
    $output .= '<label>Id:';
    $output .= "<input value=\"{$id}\" type=\"number\" name=\"id\">";
    $output .= "<br>";
    $output .= '<label>Title:';
    $output .= "<input value=\"{$title}\" type=\"text\" name=\"title\">";
    $output .= "<br>";
    $output .= '<label>Category:';
    $output .= "<input value=\"{$cat}\" type=\"text\" name=\"category\">";
    $output .= "<br>";
    $output .= '<label>Content:';
    $output .= "<input value=\"{$text}\" type=\"text\" name=\"content\">";
    $output .= "<br>";
    $output .= '<label>Author:';
    $output .= "<input value=\"{$author}\" type=\"text\" name=\"author\">";
    $output .= "<br>";
    $output .= '<label>Pubdate:';
    $output .= "<input value=\"{$pubdate}\" type=\"text\" name=\"pubdate\">";
    $output .= "<br>";
    $output .= "<input type=\"submit\" value=\"update\" name=\"action\">";
    $output .= "<input type=\"submit\" value=\"delete\" name=\"action\">";
    $output .= "</form>";
    return $output;
}

function showArticleFormCreate()
{
    $output ='<form method="post" action="create_process_article.php">';
    $output .= '<label>Id:';
    $output .= "<input value=\"\" type=\"number\" name=\"id\">";
    $output .= "<br>";
    $output .= '<label>Title:';
    $output .= "<input value=\"\" type=\"text\" name=\"title\">";
    $output .= "<br>";
    $output .= '<label>Category:';
    $output .= "<input value=\"\" type=\"text\" name=\"category\">";
    $output .= "<br>";
    $output .= '<label>Content:';
    $output .= "<input value=\"\" type=\"text\" name=\"content\">";
    $output .= "<br>";
    $output .= '<label>Author:';
    $output .= "<input value=\"\" type=\"text\" name=\"author\">";
    $output .= "<br>";
    $output .= '<label>Pubdate:';
    $output .= "<input value=\"\" type=\"text\" name=\"pubdate\">";
    $output .= "<br>";
    $output .= "<input type=\"submit\" value=\"Skapa\">";
    $output .= "</form>";
    return $output;
}

function recreateDb()
{
    copy("db\bmo2.sqlite.old", "db\bmo2.sqlite");
}
