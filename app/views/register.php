<?php include 'layouts/header.php'; ?>

<div class="container">
    <h2>Register</h2>
    <form action="/foodfusion/public/auth/register" method="POST">
        <!-- Security: CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? htmlspecialchars($csrf_token) : ''; ?>">
        
        <label>First Name</label>
        <input type="text" name="first_name" required>
        
        <label>Last Name</label>
        <input type="text" name="last_name" required>
        
        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <button type="submit">Sign Up</button>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>