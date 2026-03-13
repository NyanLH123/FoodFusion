<footer class="site-footer">
    <div class="container-wide footer-grid">
        <div>
            <p class="logo">FoodFusion</p>
            <p class="muted">&copy; 2026 FoodFusion. All rights reserved.</p>
        </div>
        <nav class="footer-links" aria-label="Footer links">
            <a href="<?= BASE_URL ?>home/index">Home</a>
            <a href="<?= BASE_URL ?>home/about">About Us</a>
            <a href="<?= BASE_URL ?>home/recipes">Recipe Collection</a>
            <a href="<?= BASE_URL ?>home/community">Community Cookbook</a>
            <a href="<?= BASE_URL ?>home/contact">Contact Us</a>
        </nav>
        <div class="footer-social">
            <a href="#" aria-label="Facebook">Facebook</a>
            <a href="#" aria-label="YouTube">YouTube</a>
            <a href="#" aria-label="X">X</a>
        </div>
        <div class="footer-legal">
            <button class="text-btn" data-modal-open="privacyModal" type="button">Privacy</button>
            <button class="text-btn" data-modal-open="cookieModal" type="button">Cookie</button>
        </div>
    </div>
</footer>

<div class="modal" id="joinUsModal" role="dialog" aria-modal="true" aria-labelledby="joinUsTitle" hidden>
    <div class="modal-panel">
        <button class="modal-close" data-modal-close type="button" aria-label="Close">×</button>
        <h2 id="joinUsTitle">Join FoodFusion</h2>
        <form class="form-grid" action="<?= BASE_URL ?>auth/register" method="post">
            <label>First Name<input type="text" name="firstname" required></label>
            <label>Last Name<input type="text" name="lastname" required></label>
            <label>Email<input type="email" name="email" required></label>
            <label>Password<input type="password" name="password" required></label>
            <label>Confirm Password<input type="password" name="confirm_password" required></label>
            <button class="btn btn-accent" type="submit">Create Account</button>
        </form>
        <p class="muted">Already have an account? <a href="<?= BASE_URL ?>auth/login">Login instead</a></p>
        <p class="status success">Success state placeholder.</p>
        <p class="status error">Error state placeholder.</p>
    </div>
</div>

<div class="modal" id="privacyModal" role="dialog" aria-modal="true" aria-labelledby="privacyTitle" hidden>
    <div class="modal-panel">
        <button class="modal-close" data-modal-close type="button" aria-label="Close">×</button>
        <h2 id="privacyTitle">Privacy Policy</h2>
        <p class="muted">Placeholder policy content for later legal copy updates.</p>
    </div>
</div>

<div class="modal" id="cookieModal" role="dialog" aria-modal="true" aria-labelledby="cookieTitle" hidden>
    <div class="modal-panel">
        <button class="modal-close" data-modal-close type="button" aria-label="Close">×</button>
        <h2 id="cookieTitle">Cookie Policy</h2>
        <p class="muted">Placeholder cookie policy content for later legal copy updates.</p>
    </div>
</div>

<div id="cookieBanner" class="cookie-banner" role="region" aria-label="Cookie consent banner">
    <p>We use cookies to improve your experience.</p>
    <div>
        <button class="btn" id="acceptCookies" type="button">Accept</button>
        <button class="btn" id="rejectCookies" type="button">Reject</button>
        <button class="btn" id="manageCookies" data-modal-open="cookieModal" type="button">Manage Preferences</button>
    </div>
</div>

<script src="<?= BASE_URL ?>js/main.js"></script>
</body>
</html>
