<?php include 'layouts/header.php'; ?>

<!-- Culinary Resources Page (Task 3 - 4 Marks) -->
<main class="culinary-page">
    <div class="container">
        <!-- Page Header -->
        <header class="page-header">
            <h1>Culinary Resources</h1>
            <p>Download recipe cards, watch cooking tutorials, and master essential kitchen techniques with our comprehensive resource library.</p>
        </header>

        <!-- Section 1: Downloadable Recipe Cards -->
        <section class="resources-section" aria-label="Downloadable Recipe Cards">
            <h2>Downloadable Recipe Cards</h2>
            <p class="section-description">Print-ready recipe cards for your kitchen collection.</p>
            
            <div class="resource-grid">
                <!-- Recipe Card 1 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/recipe-card-pasta.jpg" alt="Pasta Carbonara Recipe Card">
                    </div>
                    <div class="card-content">
                        <h3>Classic Pasta Carbonara</h3>
                        <p>Traditional Italian recipe with step-by-step instructions.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">2.5 MB</span>
                        </div>
                        <a href="assets/downloads/carbonara-recipe.pdf" class="btn-download" download>
                            Download Recipe Card
                        </a>
                    </div>
                </article>

                <!-- Recipe Card 2 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/recipe-card-curry.jpg" alt="Vegetable Curry Recipe Card">
                    </div>
                    <div class="card-content">
                        <h3>Spicy Vegetable Curry</h3>
                        <p>Healthy and flavorful curry for all skill levels.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">1.8 MB</span>
                        </div>
                        <a href="assets/downloads/curry-recipe.pdf" class="btn-download" download>
                            Download Recipe Card
                        </a>
                    </div>
                </article>

                <!-- Recipe Card 3 -->
                <article class="resource-card">
                    <div class="card-image">
                        <img src="assets/images/recipe-card-cake.jpg" alt="Chocolate Cake Recipe Card">
                    </div>
                    <div class="card-content">
                        <h3>Ultimate Chocolate Cake</h3>
                        <p>Decadent dessert recipe with frosting guide.</p>
                        <div class="resource-meta">
                            <span class="file-type">PDF</span>
                            <span class="file-size">3.2 MB</span>
                        </div>
                        <a href="assets/downloads/cake-recipe.pdf" class="btn-download" download>
                            Download Recipe Card
                        </a>
                    </div>
                </article>
            </div>
        </section>

        <!-- Section 2: Cooking Tutorials -->
        <section class="resources-section" aria-label="Cooking Tutorials">
            <h2>Cooking Tutorials</h2>
            <p class="section-description">Step-by-step video guides to enhance your cooking skills.</p>
            
            <div class="tutorial-grid">
                <!-- Tutorial 1 -->
                <article class="tutorial-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/tutorial-knife.jpg" alt="Knife Skills Tutorial">
                        <button class="play-button" aria-label="Play Knife Skills Tutorial">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>Essential Knife Skills</h3>
                        <p>Learn proper cutting techniques for safety and efficiency.</p>
                        <div class="resource-meta">
                            <span class="duration">15 mins</span>
                            <span class="difficulty">Beginner</span>
                        </div>
                        <a href="tutorial.php?id=1" class="btn-view">Watch Tutorial</a>
                    </div>
                </article>

                <!-- Tutorial 2 -->
                <article class="tutorial-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/tutorial-sauce.jpg" alt="Mother Sauces Tutorial">
                        <button class="play-button" aria-label="Play Mother Sauces Tutorial">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>The 5 Mother Sauces</h3>
                        <p>Master the foundation of French cuisine.</p>
                        <div class="resource-meta">
                            <span class="duration">25 mins</span>
                            <span class="difficulty">Intermediate</span>
                        </div>
                        <a href="tutorial.php?id=2" class="btn-view">Watch Tutorial</a>
                    </div>
                </article>

                <!-- Tutorial 3 -->
                <article class="tutorial-card">
                    <div class="video-thumbnail">
                        <img src="assets/images/tutorial-bread.jpg" alt="Bread Making Tutorial">
                        <button class="play-button" aria-label="Play Bread Making Tutorial">▶</button>
                    </div>
                    <div class="card-content">
                        <h3>Homemade Bread Basics</h3>
                        <p>From kneading to baking your first loaf.</p>
                        <div class="resource-meta">
                            <span class="duration">40 mins</span>
                            <span class="difficulty">Advanced</span>
                        </div>
                        <a href="tutorial.php?id=3" class="btn-view">Watch Tutorial</a>
                    </div>
                </article>
            </div>
        </section>

        <!-- Section 3: Instructional Videos - Kitchen Hacks -->
        <section class="resources-section" aria-label="Kitchen Hacks">
            <h2>Kitchen Hacks & Tips</h2>
            <p class="section-description">Quick tips and tricks to make cooking easier and more enjoyable.</p>
            
            <div class="hacks-list">
                <!-- Hack 1 -->
                <article class="hack-card">
                    <div class="hack-icon">🔪</div>
                    <div class="hack-content">
                        <h3>Peel Garlic in Seconds</h3>
                        <p>Shake garlic cloves in a sealed jar for 10 seconds to remove skins effortlessly.</p>
                        <a href="assets/videos/garlic-hack.mp4" class="btn-download" download>Watch Video</a>
                    </div>
                </article>

                <!-- Hack 2 -->
                <article class="hack-card">
                    <div class="hack-icon">🥚</div>
                    <div class="hack-content">
                        <h3>Perfect Hard-Boiled Eggs</h3>
                        <p>Add vinegar to water for easier peeling and consistent results every time.</p>
                        <a href="assets/videos/egg-hack.mp4" class="btn-download" download>Watch Video</a>
                    </div>
                </article>

                <!-- Hack 3 -->
                <article class="hack-card">
                    <div class="hack-icon">🧀</div>
                    <div class="hack-content">
                        <h3>Store Cheese Properly</h3>
                        <p>Wrap in parchment paper before plastic to prevent moisture buildup and mold.</p>
                        <a href="assets/videos/cheese-hack.mp4" class="btn-download" download>Watch Video</a>
                    </div>
                </article>

                <!-- Hack 4 -->
                <article class="hack-card">
                    <div class="hack-icon">🍋</div>
                    <div class="hack-content">
                        <h3>Extract More Juice</h3>
                        <p>Roll citrus fruits on the counter before cutting to release more juice.</p>
                        <a href="assets/videos/citrus-hack.mp4" class="btn-download" download>Watch Video</a>
                    </div>
                </article>
            </div>
        </section>

        <!-- Section 4: Resource Categories Filter -->
        <section class="resources-filter" aria-label="Filter Resources">
            <h2>Browse by Category</h2>
            <div class="category-tags">
                <a href="culinary.php?category=all" class="tag active">All</a>
                <a href="culinary.php?category=techniques" class="tag">Techniques</a>
                <a href="culinary.php?category=baking" class="tag">Baking</a>
                <a href="culinary.php?category=preparation" class="tag">Preparation</a>
                <a href="culinary.php?category=storage" class="tag">Food Storage</a>
                <a href="culinary.php?category=safety" class="tag">Kitchen Safety</a>
            </div>
        </section>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>  