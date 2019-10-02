<main id="admin">
    <article class="admin">
        <h2>Database Admin</h2>
        <?php if (!($_SESSION["user"] ?? null)) : ?>
            <p>Du måste vara inloggad för att kunna läsa det här.</p>
            </article>
            </main>
            <?php return; ?>
        <?php endif; ?>
        <p>This is an admin page for the database. Here we can update, and re-create the database.</p>
        <?= showObjektFormCreate() ?>
    </article>
</main>
