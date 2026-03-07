<?php include 'layouts/header.php'; ?>

<!-- Registration Page -->
<main class="auth-page register-page">
    <div class="auth-container">
        <div class="auth-card">   
            <h1>Join FoodFusion</h1>
            <p class="auth-subtitle">Create your account to access recipes and community features</p>
            
            <!-- Display Success Message -->
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                    <br>
                    <a href="login.php">Login here</a>
                </div>
            <?php endif; ?>
            
            <!-- Display Error Messages -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error" role="alert">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <!-- Registration Form (Task 2 & 4) -->
            <form action="register.php" method="POST" novalidate>
                <!-- Task 2: Security - CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                
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
                    <small id="password-requirements" class="form-help">
                        Must be 8+ characters with 1 uppercase letter and 1 number
                    </small>
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
                
                <!-- Task 4: Privacy & Cookie Consent -->
                <div class="form-group checkbox-group">
                    <input 
                        type="checkbox" 
                        id="terms" 
                        name="terms" 
                        required
                        aria-required="true"
                    >
                    <label for="terms">
                        I agree to the <a href="privacy.php" target="_blank">Privacy Policy</a> and 
                        <a href="cookies.php" target="_blank">Cookie Policy</a>
                    </label>
                </div>
                
                <button class="btn-primary" type="submit" name="register">
                    Create Account
                </button>
            </form>
            
            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
            
            <!-- Task 4: Social Media Integration -->
            <div class="social-register">
                <p>Or sign up with</p>
                <div class="social-buttons">
                    <a href="#" class="btn-social facebook" aria-label="Sign up with Facebook">
                        Facebook
                    </a>
                    <a href="#" class="btn-social google" aria-label="Sign up with Google">
                        Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'layouts/footer.php'; ?>

<!-- Client-side Validation Script -->
<script>
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    if(form) {
        form.addEventListener('submit', function(e) {
            // Password match validation
            if (password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                confirmPassword.focus();
            }
            
            // Password strength validation
            const passwordPattern = /^(?=.*[A-Z])(?=.*[0-9]).{8,}$/;
            if (!passwordPattern.test(password.value)) {
                e.preventDefault();
                alert('Password must be 8+ characters with 1 uppercase letter and 1 number.');
                password.focus();
            }
        });
    }
</script>