<article class="protected">
    <h2>Editera artiklar och objekt</h2>
    <?php if (!($_SESSION["user"] ?? null)) : ?>
        <p>Du måste vara inloggad för att kunna läsa det här.</p>
        <?php return; ?>
    <?php endif; ?>
    <?php
    $type = $_GET["type"];
    $id = $_GET["id"];
    if ($type == "objekt") {
        $content = getFromDatabase($dsn, $type, $id);
        echo showObjektForm($content);
    } else {
        $content = getFromDatabase($dsn, $type, $id);
        echo showArticleForm($content);
    }
    ?>
</article>
