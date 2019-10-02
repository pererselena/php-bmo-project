<main id="admin">
    <article class="admin">
        <h2>Database Admin</h2>
        <?php if (!($_SESSION["user"] ?? null)) : ?>
            <p>Du måste vara inloggad för att kunna läsa det här.</p>
            <?php if ($page) : ?>
                <?php require $page["file"] ?>
            <?php else : ?>
                <p>You have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
            <?php endif; ?>

            </article>
            </main>
            <?php return; ?>
        <?php endif; ?>
        <p>This is an admin page for the database. Here we can update, and re-create the database.</p>
        <form method="post" action="?page=logout-process">
                <input type="submit" name="logout" value="Logout">
        </form>
        <form method="post" action="init_database.php">
            <input type="submit" name="logout" value="RecreateDB">
        </form>
        <?php if ($page) : ?>
            <?php require $page["file"] ?>
        <?php else : ?>
            <p>You have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
        <?php endif; ?>
    </article>
</main>
