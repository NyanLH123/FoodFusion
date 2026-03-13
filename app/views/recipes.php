<?php include 'layouts/header.php'; ?>
<main id="main-content" class="section container recipes-page">
    <h1>Recipe Collection</h1>

    <section class="filters">
        <details open><summary>Cuisine</summary><div class="chip-row"><span class="chip">Italian</span><span class="chip">Indian</span><span class="chip">Thai</span><span class="chip">Japanese</span><span class="chip">Mexican</span></div></details>
        <details open><summary>Diet</summary><div class="chip-row"><span class="chip">Vegan</span><span class="chip">Vegetarian</span><span class="chip">Gluten-Free</span><span class="chip">Keto</span></div></details>
        <details open><summary>Difficulty</summary><div class="chip-row"><span class="chip">Easy</span><span class="chip">Medium</span><span class="chip">Hard</span></div></details>
        <div class="inline-controls"><input type="search" placeholder="Search recipes"><select><option>Sort by Rating</option></select></div>
    </section>

    <section class="card-grid three">
        <article class="card recipe"><h3><a href="<?= BASE_URL ?>home/recipeDetail">Creamy Mushroom Risotto</a></h3><p>35 min · Medium · ★4.8</p><p>Classic Italian comfort with parmesan finish.</p></article>
        <article class="card recipe"><h3><a href="<?= BASE_URL ?>home/recipeDetail">Chana Masala Bowl</a></h3><p>30 min · Easy · ★4.7</p><p>Indian pantry staple rich in spice and protein.</p></article>
        <article class="card recipe"><h3><a href="<?= BASE_URL ?>home/recipeDetail">Spicy Miso Ramen</a></h3><p>40 min · Hard · ★4.9</p><p>Japanese-inspired broth with layered umami.</p></article>
    </section>

    <nav class="pagination" aria-label="Pagination">
        <button class="btn" disabled>Prev</button>
        <button class="btn active">1</button>
        <button class="btn">2</button>
        <button class="btn">3</button>
        <button class="btn">Next</button>
    </nav>
</main>
<?php include 'layouts/footer.php'; ?>
