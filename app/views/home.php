<?php include 'layouts/header.php'; ?>

<!-- Hero Section: Mission Statement -->
<header class="hero">
    <h1>Welcome to FoodFusion</h1>
    <p>Promoting home cooking and culinary creativity among food enthusiasts.</p>
    
    <!-- Task 4: Social Media Links Prominently Displayed -->
    <div class="hero-socials" aria-label="Social Media Links">
        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">Facebook</a>
        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter">Twitter</a>
        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">Instagram</a>
    </div>
    
    <!-- Login CTA for Task 2 Security Requirements -->
    <div class="auth-buttons">
        <a href="login.php" class="btn-login">Login</a>
        <button id="openJoinUs" class="btn-signup" aria-haspopup="dialog">Join Us</button>
    </div>
</header>

<!-- Task 4: "Join Us" Pop-up Form (Registration) -->
<!-- Structure for Modal - Hidden by default via CSS, triggered by JS -->
    <div id="joinUsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Join Our Community</h2>
            <form action="/foodfusion/public/auth/register" method="POST">
                <!-- CSRF Protection -->
                <div class="form-group">
                    <label for="firstname">First Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="firstname" 
                        name="firstname" 
                        
                        required 
                        autocomplete="given-name"
                        aria-required="true"
                        aria-describedby="firstname-error"
                    >
                </div>
                
                <div class="form-group">
                    <label for="lastname">Last Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="lastname" 
                        name="lastname" 
                        
                        required 
                        autocomplete="family-name"
                        aria-required="true"
                        aria-describedby="lastname-error"
                    >
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        
                        required 
                        autocomplete="email"
                        aria-required="true"
                        aria-describedby="email-error"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        aria-required="true"
                        aria-describedby="password-requirements"
                        minlength="8"
                    >
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        required 
                        autocomplete="new-password"
                        aria-required="true"
                    >
                </div>
                <button type="submit" class="btn-primary">Sign Up Now</button>
            </form>
        </div>
    </div>

<!-- Task 3: Carousel for Upcoming Cooking Events -->
<section class="carousel" aria-label="Upcoming Cooking Events">
    <h2>Upcoming Cooking Events</h2>
    <div class="carousel-container">
        <!-- Slide 1 -->
        <div class="slide">
            <img src="assets/images/event-italian.jpg" alt="Italian Night Cooking Class">
            <h3>Italian Night</h3>
            <p>Join us for a live cooking session on Pasta Making!</p>
            <date>2026-11-15</date>
        </div>
        <!-- Slide 2 -->
        <div class="slide">
            <img src="assets/images/event-asian.jpg" alt="Asian Fusion Workshop">
            <h3>Asian Fusion Workshop</h3>
            <p>Learn the secrets of Wok cooking.</p>
            <date>2026-11-20</date>
        </div>
        <!-- Slide 3 -->
        <div class="slide">
            <img src="assets/images/event-dessert.jpg" alt="Healthy Desserts Class">
            <h3>Healthy Desserts</h3>
            <p>Sweet treats without the guilt.</p>
            <date>2026-11-25</date>
        </div>
    </div>
    <!-- Carousel Controls -->
    <button class="prev" aria-label="Previous Slide">&#10094;</button>
    <button class="next" aria-label="Next Slide">&#10095;</button>
</section>

<!-- Task 3: Integrated News Feed (Recipes & Trends) -->
<section class="news-feed">
    <h2>FoodFusion News & Recipes</h2>
    
    <!-- Featured Recipes -->
    <div class="feed-section">
        <h3>Featured Recipes</h3>
        <div class="recipe-grid">
            <div class="card">
                <img src="assets/images/pasta.jpg" alt="Plate of Pasta Carbonara">
                <h3>Pasta Carbonara</h3>
                <p>Classic Italian dish.</p>
                <a href="recipe.php?id=1">View Recipe</a>
                <!-- Task 4: Social Media Integration (Share Buttons) -->
                <div class="share-links">
                    <span>Share:</span>
                    <a href="#" aria-label="Share on Facebook">FB</a>
                    <a href="#" aria-label="Share on Twitter">TW</a>
                </div>
            </div>
            <div class="card">
                <img src="assets/images/curry.jpg" alt="Vegetable Curry Dish">
                <h3>Vegetable Curry</h3>
                <p>Spicy and healthy.</p>
                <a href="recipe.php?id=2">View Recipe</a>
                <div class="share-links">
                    <span>Share:</span>
                    <a href="#" aria-label="Share on Facebook">FB</a>
                    <a href="#" aria-label="Share on Twitter">TW</a>
                </div>
            </div>
            <div class="card">
                <img src="assets/images/cake.jpg" alt="Chocolate Cake Slice">
                <h3>Chocolate Cake</h3>
                <p>Dessert favorite.</p>
                <a href="recipe.php?id=3">View Recipe</a>
                <div class="share-links">
                    <span>Share:</span>
                    <a href="#" aria-label="Share on Facebook">FB</a>
                    <a href="#" aria-label="Share on Twitter">TW</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Culinary Trends -->
    <div class="feed-section">
        <h3>Culinary Trends</h3>
        <div class="trend-grid">
            <div class="card">
                <h3>Sustainable Cooking</h3>
                <p>How to reduce waste in the kitchen.</p>
            </div>
            <div class="card">
                <h3>Plant-Based Revolution</h3>
                <p>The rise of vegan gourmet.</p>
            </div>
        </div>
    </div>
</section>

<!-- Task 4: Cookie Consent Pop-up -->
<div id="cookieConsent" class="cookie-banner" role="alert">
    <p>We use cookies to enhance your experience and track user interactions. <a href="privacy.php">Privacy Policy</a></p>
    <button id="acceptCookies">Accept</button>
</div>

<?php include 'layouts/footer.php'; ?>

<!-- Placeholder for JavaScript functionality -->
<!-- In production, this would be in a separate .js file -->
<script>
    // Modal Logic for Join Us
    const modal = document.getElementById("joinUsModal");
    const btn = document.getElementById("openJoinUs");
    const span = document.getElementsByClassName("close")[0];

    if(btn) {
        btn.onclick = function() { modal.style.display = "block"; }
    }
    if(span) {
        span.onclick = function() { modal.style.display = "none"; }
    }
    // Close modal if clicked outside
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
    // Cookie Consent Logic
    const cookieBanner = document.getElementById("cookieConsent");
    const acceptBtn = document.getElementById("acceptCookies");
    
    if(!localStorage.getItem('cookiesAccepted')) {
        cookieBanner.style.display = "flex";
    } else {
        cookieBanner.style.display = "none";
    }

    if(acceptBtn) {
        acceptBtn.onclick = function() {
            localStorage.setItem('cookiesAccepted', 'true');
            cookieBanner.style.display = "none";
        }
    }
</script>

