<?php include 'layouts/header.php'; ?>

<div class="container">
    <h2>Contact Us</h2>
    <?php if(isset($success) && !empty($success)): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    
    <form action="/foodfusion/public/contact" method="POST">
        <!-- Security: CSRF Token -->
        <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? htmlspecialchars($csrf_token) : ''; ?>">
        
        <label>Name</label>
        <input type="text" name="name" required>
        
        <label>Email</label>
        <input type="email" name="email" required>
        
        <label>Message</label>
        <textarea name="message" required></textarea>
        
        <button type="submit">Send Message</button>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>