<?php include 'layouts/header.php'; ?>

<!-- Login Page -->
<main class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1>Welcome Back</h1>
            <p class="auth-subtitle">Login to access your FoodFusion account</p>

            <!-- Success Message (Passed from Controller/Logic) -->
            <?php if (!empty($success ?? '')): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- Lockout Message (Passed from Controller/Logic) -->
            <?php if (!empty($lockoutMessage ?? '')): ?>
                <div class="alert alert-lockout" role="alert">
                    <?php echo htmlspecialchars($lockoutMessage); ?>
                </div>
            <?php endif; ?>

            <!-- Error Messages (Passed from Controller/Logic) -->
            <?php if (!empty($error ?? '')): ?>
                <div class="alert alert-error" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="<?php echo BASE_URL; ?>auth/authenticate" method="POST" novalidate>
                <!-- Task 2: Security - CSRF Token Field -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?php echo htmlspecialchars($oldEmail ?? ''); ?>"
                        required
                        autocomplete="email"
                        aria-required="true"
                        <?php echo !empty($lockoutMessage) ? 'disabled' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        aria-required="true"
                        <?php echo !empty($lockoutMessage) ? 'disabled' : ''; ?>>
                </div>

                <div class="form-group checkbox-group">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        <?php echo !empty($lockoutMessage) ? 'disabled' : ''; ?>>
                    <label for="remember">Remember me</label>
                </div>

                <button
                    type="submit"
                    name="login"
                    class="btn-primary"
                    <?php echo !empty($lockoutMessage) ? 'disabled' : ''; ?>>
                    Login
                </button>
            </form>

            <div class="auth-footer">
                <p><a href="forgot-password.php">Forgot your password?</a></p>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>

            <div class="social-login">
                <p>Or login with</p>
                <div class="social-buttons">
                    <a href="#" class="btn-social facebook" aria-label="Login with Facebook">Facebook</a>
                    <a href="#" class="btn-social google" aria-label="Login with Google">Google</a>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Lockout Countdown Timer Script -->
<script>
    const lockoutMessage = document.querySelector('.alert-lockout');

    if (lockoutMessage) {
        const timeMatch = lockoutMessage.textContent.match(/(\d+) minutes and (\d+) seconds/);

        if (timeMatch) {
            let minutes = parseInt(timeMatch[1]);
            let seconds = parseInt(timeMatch[2]);

            const countdown = setInterval(function() {
                seconds--;
                if (seconds < 0) {
                    minutes--;
                    seconds = 59;
                }
                if (minutes < 0) {
                    clearInterval(countdown);
                    location.reload();
                } else {
                    lockoutMessage.textContent =
                        '🔒 Account locked for security. Please try again in ' +
                        minutes + ' minutes and ' +
                        (seconds < 10 ? '0' : '') + seconds + ' seconds.';
                }
            }, 1000);
        }
    }
</script>

<?php include 'layouts/footer.php'; ?>