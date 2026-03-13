<?php include 'layouts/header.php'; ?>
<main id="main-content">
    <section class="hero section">
        <div class="hero-overlay">
            <p class="eyebrow"> </p>
            <h1>Cook Better, Share More, Live Deliciously.</h1>
            <p class="subtitle">A clean home for modern recipes, trends, community stories, and practical learning.</p>
            <button class="btn btn-accent" id="heroJoinUs" type="button">Join Us</button>
        </div>
    </section>

    <section class="section container">
        <h2>Mission</h2>
        <p class="muted">FoodFusion inspires everyday cooks to create confidently, explore global food culture, and build meaningful community through simple, sustainable cooking.</p>
    </section>

    <section class="section container">
        <h2>Featured Recipes / Trends</h2>
        <div class="card-grid three">
            <article class="card"><h3>Italian Lemon Pasta</h3><p>15-minute comfort with bright seasonal flavor.</p></article>
            <article class="card"><h3>Zero-Waste Broth Trend</h3><p>How home cooks are turning scraps into rich stock.</p></article>
            <article class="card"><h3>Thai Basil Tofu Bowl</h3><p>Bold weeknight dish with plant-forward protein.</p></article>
        </div>
    </section>

    <section class="section container">
        <h2>Upcoming Cooking Events Carousel</h2>
        <div class="events-track" id="eventsTrack">
            <article class="card event-card"><h3>Street Taco Night</h3><p>May 12 · Live workshop</p></article>
            <article class="card event-card"><h3>Knife Skills Lab</h3><p>May 19 · Practical techniques</p></article>
            <article class="card event-card"><h3>Plant-Based Sunday</h3><p>May 27 · Community cook-along</p></article>
        </div>
    </section>

    <section class="section container two-col">
        <div>
            <h2>About Preview</h2>
            <p class="muted">Learn how FoodFusion started, what drives our values, and who helps shape the platform.</p>
            <a class="btn" href="<?= BASE_URL ?>home/about">Explore About Us</a>
        </div>
        <div>
            <h2>Community Preview</h2>
            <p class="muted">Browse social-style cooking posts from members sharing stories, wins, and kitchen experiments.</p>
            <a class="btn" href="<?= BASE_URL ?>home/community">Visit Community Cookbook</a>
        </div>
    </section>

    <section class="section container two-col">
        <div class="card">
            <h3>Culinary Resources</h3>
            <p>Technique videos, tutorials, and practical kitchen hacks.</p>
            <a class="btn" href="<?= BASE_URL ?>home/culinary">Open Culinary Resources</a>
        </div>
        <div class="card">
            <h3>Educational Resources</h3>
            <p>Food sustainability and eco-kitchen learning for everyday life.</p>
            <a class="btn" href="<?= BASE_URL ?>home/educational">Open Educational Resources</a>
        </div>
    </section>
</main>
<?php include 'layouts/footer.php'; ?>
