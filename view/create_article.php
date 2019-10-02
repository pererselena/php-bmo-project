<main id="admin">
    <article class="admin">
        <h2>Database Admin</h2>
        <?php if (!($_SESSION["user"] ?? null)) : ?>
            <p>Du måste vara inloggad för att kunna läsa det här.</p>
            </article>
            </main>
            <?php return; ?>
        <?php endif; ?>
        <p>Giltiga kategorier: maggy, article, about <br>
            om något annat väljs kommer artikeln inte att visas.
        </p>
        <?= showArticleFormCreate() ?>
    </article>
</main>
