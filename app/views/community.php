<?php include 'layouts/header.php'; ?>

<!-- Community Cookbook Page (Task 3 - 8 Marks) -->
<main class="community-page">
    <div class="container">
        <!-- Page Header -->
        <header class="page-header">
            <h1>Community Cookbook</h1>
            <p>Share your favourite recipes, cooking tips and culinary experiences with the FoodFusion community.</p>
        </header>

        <!-- Task 3: Collaborative Space - Submission Form -->
        <section class="community-submit">
            <div class="submit-card">
                <h2>Share Your Creation</h2>
                <p>Contribute to our community by sharing your unique recipes and cooking tips.</p>
                
                <form action="community.php" method="POST" enctype="multipart/form-data">
                    <!-- Task 2: Security - CSRF Token Field -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="post-title">Recipe/Tip Title <span class="required">*</span></label>
                            <input type="text" id="post-title" name="post_title" required placeholder="e.g., Grandma's Secret Lasagna">
                        </div>
                        
                        <div class="form-group">
                            <label for="post-category">Category</label>
                            <select id="post-category" name="post_category">
                                <option value="recipe">Recipe</option>
                                <option value="tip">Cooking Tip</option>
                                <option value="experience">Culinary Experience</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="post-description">Description & Ingredients <span class="required">*</span></label>
                        <textarea id="post-description" name="post_description" rows="5" required placeholder="Share your ingredients and method..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="post-image">Upload Photo</label>
                        <input type="file" id="post-image" name="post_image" accept="image/*">
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="guidelines" name="guidelines" required>
                        <label for="guidelines">
                            I agree to the <a href="privacy.php">Community Guidelines</a> and <a href="privacy.php">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" name="submit_post" class="btn-primary">Post to Community</button>
                </form>
            </div>
        </section>

        <!-- Task 3: Community Feed -->
        <section class="community-feed" aria-label="Community Posts">
            <h2>Latest from the Community</h2>
            
            <!-- Post 1 -->
            <article class="community-card">
                <div class="post-header">
                    <div class="user-avatar">
                        <img src="assets/images/user1.jpg" alt="User Avatar">
                    </div>
                    <div class="post-meta">
                        <h4><?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'John'); ?> <?php echo htmlspecialchars($_SESSION['user_lastname'] ?? 'Doe'); ?></h4>
                        <span class="post-date">2 hours ago</span>
                        <span class="post-category">Recipe</span>
                    </div>
                </div>
                
                <div class="post-content">
                    <h3><a href="recipe-detail.php?id=101">Homemade Sourdough Bread</a></h3>
                    <img src="assets/images/sourdough.jpg" alt="Fresh Sourdough Bread" class="post-image">
                    <p>After many attempts, I finally perfected my sourdough starter! Here's my method for achieving the perfect crust...</p>
                    <a href="#" class="read-more">Read Full Recipe</a>
                </div>
                
                <div class="post-actions">
                    <!-- Task 4: Social Media Integration -->
                    <div class="interaction-buttons">
                        <button class="btn-like" aria-label="Like this post">❤️ 24</button>
                        <button class="btn-comment" aria-label="Comment on this post">💬 5</button>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Post 2 -->
            <article class="community-card">
                <div class="post-header">
                    <div class="user-avatar">
                        <img src="assets/images/user2.jpg" alt="User Avatar">
                    </div>
                    <div class="post-meta">
                        <h4><?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'Jane'); ?> <?php echo htmlspecialchars($_SESSION['user_lastname'] ?? 'Smith'); ?></h4>
                        <span class="post-date">5 hours ago</span>
                        <span class="post-category">Cooking Tip</span>
                    </div>
                </div>
                
                <div class="post-content">
                    <h3>Knife Safety Tips for Beginners</h3>
                    <img src="assets/images/knife-safety.jpg" alt="Knife Safety" class="post-image">
                    <p>Always keep your knives sharp! A dull knife requires more force and is more likely to slip. Here are my top 5 safety rules...</p>
                    <a href="#" class="read-more">Read Full Tip</a>
                </div>
                
                <div class="post-actions">
                    <div class="interaction-buttons">
                        <button class="btn-like" aria-label="Like this post">❤️ 42</button>
                        <button class="btn-comment" aria-label="Comment on this post">💬 12</button>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Post 3 -->
            <article class="community-card">
                <div class="post-header">
                    <div class="user-avatar">
                        <img src="assets/images/user3.jpg" alt="User Avatar">
                    </div>
                    <div class="post-meta">
                        <h4><?php echo htmlspecialchars($_SESSION['user_firstname'] ?? 'Mike'); ?> <?php echo htmlspecialchars($_SESSION['user_lastname'] ?? 'Brown'); ?></h4>
                        <span class="post-date">1 day ago</span>
                        <span class="post-category">Culinary Experience</span>
                    </div>
                </div>
                
                <div class="post-content">
                    <h3>My Trip to a Italian Vineyard</h3>
                    <img src="assets/images/vineyard.jpg" alt="Italian Vineyard" class="post-image">
                    <p>Last summer I visited Tuscany and learned the art of pairing wine with pasta. Here are some photos and lessons learned...</p>
                    <a href="#" class="read-more">Read Full Story</a>
                </div>
                
                <div class="post-actions">
                    <div class="interaction-buttons">
                        <button class="btn-like" aria-label="Like this post">❤️ 89</button>
                        <button class="btn-comment" aria-label="Comment on this post">💬 23</button>
                        <div class="share-buttons">
                            <a href="#" aria-label="Share on Facebook">FB</a>
                            <a href="#" aria-label="Share on Twitter">TW</a>
                        </div>
                    </div>
                </div>
            </article>

        </section>

        <!-- Pagination -->
        <nav class="pagination" aria-label="Community Posts Pagination">
            <a href="#" class="page-link prev">Previous</a>
            <a href="#" class="page-link active">1</a>
            <a href="#" class="page-link">2</a>
            <a href="#" class="page-link">3</a>
            <a href="#" class="page-link next">Next</a>
        </nav>
    </div>
</main>

<!-- Simple Interaction Script (UI Only) -->
<script>
    // Like button toggle effect
    const likeButtons = document.querySelectorAll('.btn-like');
    likeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('liked');
            // In production, this would send an AJAX request to the server
        });
    });
</script>

<?php include 'layouts/footer.php'; ?>