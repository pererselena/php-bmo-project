<main  id="artiklar">
    <article class="subpage">
        <?php if ($page) : ?>
            <?= printArticles($page["content"]) ?>
        <?php else : ?>
            <p>You have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
        <?php endif; ?>
    </article>
</main>
