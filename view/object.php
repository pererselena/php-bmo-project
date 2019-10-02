<main id="objekt">
    <article class="objects" >
        <?php if ($page) : ?>
            <h2><?= $page["title"] ?></h2>
            <?= printObjects($page["content"]) ?>
        <?php else : ?>
            <p>You have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
        <?php endif; ?>
    </article>
</main>
