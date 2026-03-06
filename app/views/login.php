<?php include 'layouts/header.php'; ?>

<div class="container">
    <h2>Login</h2>
    <?php if(isset($error) && !empty($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <form action="/foodfusion/public/auth/login" method="POST">
        <!-- Security: CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? htmlspecialchars($csrf_token) : ''; ?>">
        
        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>