<?php

use app\core\Session; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo htmlspecialchars($title ?? 'Home'); ?></title>
    <link rel="stylesheet" href="<?= BASE_URL . 'public/css/style.css' ?>">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">FoodFusion</div>
        <ul class="nav-links">
            <!-- FIXED: Use Router URLs (not file paths) -->
            <li><a href="<?= BASE_URL ?>home">Home</a></li>
            <li><a href="<?= BASE_URL ?>home/about">About Us</a></li>
            <li><a href="<?= BASE_URL ?>home/recipes">Recipes</a></li>
            <li><a href="<?= BASE_URL ?>home/community">Community</a></li>
            <li><a href="<?= BASE_URL ?>home/culinary">Culinary</a></li>
            <li><a href="<?= BASE_URL ?>home/educational">Educational</a></li>
            <li><a href="<?= BASE_URL ?>contact">Contact</a></li>

            <?php if (Session::get('user_id')): ?>
                <li><a href="<?= BASE_URL ?>auth/logout">Logout (<?php echo htmlspecialchars(Session::get('user_name')); ?>)</a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>auth">Login</a></li>
            <?php endif; ?>
        </ul>
        <button id="joinUsBtn" class="btn-primary">Join Us</button>
    </nav>

    <!-- Task 4: Join Us Pop-up Form -->
    <div id="joinUsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Join Our Community</h2>
            <form action="/foodfusion/public/auth/register" method="POST">
                <!-- CSRF Protection -->
                <input type="hidden" name="csrf_token" value="<?php echo isset($csrf_token) ? htmlspecialchars($csrf_token) : (isset($_SESSION['csrf_token']) ? htmlspecialchars($_SESSION['csrf_token']) : ''); ?>">

                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up Now</button>
            </form>
        </div>
    </div>

    <!-- Task 4: Cookie Consent Banner -->
    <div id="cookieConsent" class="cookie-banner">
        <p>We use cookies to enhance your experience. <a href="/foodfusion/public/home/privacy">Privacy Policy</a></p>
        <button id="acceptCookies">Accept</button>
    </div>