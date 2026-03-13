<?php include 'layouts/header.php'; ?>
<main id="main-content" class="section container">
    <h1>Community Cookbook</h1>
    <button id="createPostToggle" class="btn btn-accent" type="button" aria-expanded="false" aria-controls="createPostForm">Create Post</button>

    <form id="createPostForm" class="form-grid hidden" action="#" method="post">
        <label>Title<input type="text" required></label>
        <label>Recipe / Story<textarea required></textarea></label>
        <label>Image Upload Placeholder<input type="file"></label>
        <label>Tags / Category<input type="text" placeholder="e.g. vegan, quick dinner"></label>
        <button class="btn" type="submit">Submit</button>
    </form>

    <section class="stack">
        <article class="card social-card"><h3>@HomeChefMia</h3><p>My 20-minute Thai basil tofu turned out amazing tonight. Added lime zest for freshness.</p><p>♥ 62 · 💬 14</p></article>
        <article class="card social-card"><h3>@SpiceRoute</h3><p>Sharing my grandmother's easy masala khichdi for rainy evenings.</p><p>♥ 47 · 💬 9</p></article>
    </section>

    <section class="section">
        <h2>Cooking Tips</h2>
        <div class="card-grid two">
            <article class="card"><h3>Salt in layers</h3><p>Season gradually while cooking for balanced flavor.</p></article>
            <article class="card"><h3>Preheat your pan</h3><p>Better sear, better texture, less sticking.</p></article>
        </div>
    </section>
</main>
<?php include 'layouts/footer.php'; ?>
