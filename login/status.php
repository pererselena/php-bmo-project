<h2>Status</h2>

<?php if ($_SESSION["user"] ?? null) : ?>
    <p>Användaren <b><?= $_SESSION["user"] ?></b>är inloggad just nu.</p>
    <p>Användarens riktiga namn är <b><?= $_SESSION["name"] ?></b>.</p>
    <a href="create_object.php">Skapa objekt</a>
    <a href="create_article.php">Skapa artikel</a>
<?php else : ?>
    <p>Ingen användare är inloggad.</p>
    <?php require __DIR__ . "/login.php"; ?>
<?php endif; ?>
