<?php

use app\core\Session; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo htmlspecialchars($title ?? 'Home'); ?></title>
    <link rel="stylesheet" href="<?= BASE_URL . 'css/style.css' ?>">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">FoodFusion</div>
        <ul class="nav-links">
            <!-- FIXED: Use Router URLs (not file paths) -->
            <li><a href="<?= BASE_URL ?>home/index">Home</a></li>
            <li><a href="<?= BASE_URL ?>home/about">About Us</a></li>
            <li><a href="<?= BASE_URL ?>home/recipes">Recipes</a></li>
            <li><a href="<?= BASE_URL ?>home/community">Community</a></li>
            <li><a href="<?= BASE_URL ?>home/culinary">Culinary</a></li>
            <li><a href="<?= BASE_URL ?>home/educational">Educational</a></li>
            <li><a href="<?= BASE_URL ?>home/contact">Contact</a></li>
        </ul>
        <ul class="nav-links">
            <?php if (Session::get('user_id')): ?>
                <li><a href="<?= BASE_URL ?>auth/logout">Logout <?php echo Session::get('user_name'); ?></a></li>
            <?php else: ?>
                <li><a href="<?= BASE_URL ?>auth/login">Login</a></li>
            <?php endif; ?>
            <li><a href="<?= BASE_URL ?>auth/index">Register</a></li>
        </ul>
    </nav>

    <div id="cookieConsent" class="cookie-banner">
        <p>We use cookies to enhance your experience. <a href="<?= BASE_URL ?>home/privacy">Privacy Policy</a></p>
        <button id="acceptCookies">Accept</button>
    </div>