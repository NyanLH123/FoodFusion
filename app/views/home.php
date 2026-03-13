<?php include 'layouts/header.php'; ?>
<main id="main-content">
    <section class="hero section">
        <div class="hero-overlay container">
            <p class="eyebrow"></p>
            <h1>FoodFusion elevates everyday cooking.</h1>
            <p class="subtitle">Discover curated recipes, meaningful culinary trends, and a thoughtful community crafted with a premium, minimal experience.</p>

        <div class="hero-overlay">
            <p class="eyebrow"> </p>
            <h1>Cook Better, Share More, Live Deliciously.</h1>
            <p class="subtitle">A clean home for modern recipes, trends, community stories, and practical learning.</p>
            <button class="btn btn-accent" id="heroJoinUs" type="button">Join Us</button>
        </div>
    </section>

    <section class="section container mission-panel">
        <h2>Mission</h2>
        <p class="muted">We empower home cooks with elegant guidance, global inspiration, and sustainability-first habits—making every kitchen session more creative and connected.</p>
    </section>

    <section class="section container">
        <div class="section-head"><h2>Featured Recipes / Trends</h2><a href="<?= BASE_URL ?>home/recipes" class="text-link">View all</a></div>
        <div class="card-grid three">
            <article class="card feature-card"><span class="chip">Recipe</span><h3>Lemon Burrata Linguine</h3><p>Silky, bright, and ready in 20 minutes with restaurant-level presentation.</p></article>
            <article class="card feature-card"><span class="chip">Trend</span><h3>Micro-Seasonal Cooking</h3><p>How chefs and home cooks are planning menus around hyper-local produce cycles.</p></article>
            <article class="card feature-card"><span class="chip">Recipe</span><h3>Thai Basil Crispy Tofu</h3><p>Bold aromatics and crisp textures with quick wok-friendly prep flow.</p></article>
        </div>
    </section>

    <section class="section container">
        <h2>Upcoming Cooking Events</h2>
        <div class="events-track" id="eventsTrack">
            <article class="card event-card"><p class="event-date">May 12</p><h3>Street Taco Night</h3><p>Live community cook-along with plating walkthrough.</p></article>
            <article class="card event-card"><p class="event-date">May 19</p><h3>Knife Skills Studio</h3><p>Precision cuts, sharpening basics, and prep-efficiency techniques.</p></article>
            <article class="card event-card"><p class="event-date">May 27</p><h3>Plant-Forward Sunday</h3><p>Flavor-dense vegetarian menu design with protein balancing.</p></article>
        </div>
    </section>

    <section class="section container two-col preview-band">
        <article class="card preview-card">
            <h2>About Preview</h2>
            <p class="muted">Explore our values, mission, and the team shaping FoodFusion’s culinary direction.</p>
            <a class="btn" href="<?= BASE_URL ?>home/about">Explore About Us</a>
        </article>
        <article class="card preview-card">
            <h2>Community Preview</h2>
            <p class="muted">Browse social-style posts from members sharing personal recipes, cooking stories, and tips.</p>
            <a class="btn" href="<?= BASE_URL ?>home/community">Visit Community Cookbook</a>
        </article>
    </section>

    <section class="section container two-col">
        <article class="card resource-preview">
            <h3>Culinary Resources</h3>
            <p>Technique videos, quick-reference cards, and practical kitchen hacks.</p>
            <a class="btn" href="<?= BASE_URL ?>home/culinary">Open Culinary Resources</a>
        </article>
        <article class="card resource-preview">
            <h3>Educational Resources</h3>
            <p>Food sustainability, eco-kitchen learning, and practical low-waste guidance.</p>
            <a class="btn" href="<?= BASE_URL ?>home/educational">Open Educational Resources</a>
        </article>

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
