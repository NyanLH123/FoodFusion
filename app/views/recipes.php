<?php include 'layouts/header.php'; ?>

<!-- Recipe Collection Page (Task 3) -->
<main class="recipes-page">
    <div class="container">
        <!-- Page Header -->
        <header class="page-header">
            <h1>Recipe Collection</h1>
            <p>Explore diverse recipes from around the world, curated for every taste and skill level.</p>
        </header>

        <!-- Filter Section (Task 3: Categorisation) -->
        <section class="recipe-filters">
            <form action="recipes.php" method="GET" class="filter-form">
                <div class="filter-group">
                    <label for="cuisine">Cuisine Type</label>
                    <select id="cuisine" name="cuisine">
                        <option value="">All Cuisines</option>
                        <option value="italian">Italian</option>
                        <option value="asian">Asian</option>
                        <option value="mexican">Mexican</option>
                        <option value="mediterranean">Mediterranean</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="dietary">Dietary Preference</label>
                    <select id="dietary" name="dietary">
                        <option value="">All Diets</option>
                        <option value="vegetarian">Vegetarian</option>
                        <option value="vegan">Vegan</option>
                        <option value="gluten-free">Gluten-Free</option>
                        <option value="keto">Keto</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="difficulty">Difficulty Level</label>
                    <select id="difficulty" name="difficulty">
                        <option value="">Any Difficulty</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">Filter Recipes</button>
            </form>
        </section>

        <!-- Recipe Grid -->
        <section class="recipe-grid" aria-label="Recipe Collection">
            
            <!-- Recipe Card 1 -->
            <article class="recipe-card">
                <div class="card-image">
                    <img src="assets/images/pasta.jpg" alt="Classic Pasta Carbonara">
                    <span class="badge difficulty-easy">Easy</span>
                </div>
                <div class="card-content">
                    <h3><a href="recipe-detail.php?id=1">Classic Pasta Carbonara</a></h3>
                    <p class="recipe-meta">
                        <span class="cuisine">Italian</span> • 
                        <span class="time">30 mins</span>
                    </p>
                    <p class="recipe-description">Authentic Italian carbonara with eggs, cheese, and guanciale.</p>
                    <div class="card-actions">
                        <a href="recipe-detail.php?id=1" class="btn-view">View Recipe</a>
                        <!-- Task 4: Social Media Integration -->
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Recipe Card 2 -->
            <article class="recipe-card">
                <div class="card-image">
                    <img src="assets/images/curry.jpg" alt="Spicy Vegetable Curry">
                    <span class="badge difficulty-medium">Medium</span>
                </div>
                <div class="card-content">
                    <h3><a href="recipe-detail.php?id=2">Spicy Vegetable Curry</a></h3>
                    <p class="recipe-meta">
                        <span class="cuisine">Asian</span> • 
                        <span class="time">45 mins</span>
                    </p>
                    <p class="recipe-description">Healthy and spicy curry packed with fresh vegetables.</p>
                    <div class="card-actions">
                        <a href="recipe-detail.php?id=2" class="btn-view">View Recipe</a>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Recipe Card 3 -->
            <article class="recipe-card">
                <div class="card-image">
                    <img src="assets/images/salad.jpg" alt="Mediterranean Quinoa Salad">
                    <span class="badge difficulty-easy">Easy</span>
                </div>
                <div class="card-content">
                    <h3><a href="recipe-detail.php?id=3">Mediterranean Quinoa Salad</a></h3>
                    <p class="recipe-meta">
                        <span class="cuisine">Mediterranean</span> • 
                        <span class="time">15 mins</span>
                    </p>
                    <p class="recipe-description">Light and refreshing salad perfect for summer lunches.</p>
                    <div class="card-actions">
                        <a href="recipe-detail.php?id=3" class="btn-view">View Recipe</a>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Recipe Card 4 -->
            <article class="recipe-card">
                <div class="card-image">
                    <img src="assets/images/tacos.jpg" alt="Beef Tacos">
                    <span class="badge difficulty-medium">Medium</span>
                </div>
                <div class="card-content">
                    <h3><a href="recipe-detail.php?id=4">Authentic Beef Tacos</a></h3>
                    <p class="recipe-meta">
                        <span class="cuisine">Mexican</span> • 
                        <span class="time">40 mins</span>
                    </p>
                    <p class="recipe-description">Traditional street-style tacos with fresh salsa.</p>
                    <div class="card-actions">
                        <a href="recipe-detail.php?id=4" class="btn-view">View Recipe</a>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

        </section>

        <!-- Pagination -->
        <nav class="pagination" aria-label="Recipe Pagination">
            <a href="#" class="page-link prev">Previous</a>
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">2</a>
            <a href="#" class="page-link">3</a>
            <a href="#" class="page-link next">Next</a>
        </nav>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>