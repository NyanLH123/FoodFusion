<?php
use app\core\Session;
$currentPath = strtolower($_GET['url'] ?? 'home/index');
function isActive(string $path, string $currentPath): string {
    return str_starts_with($currentPath, $path) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion - <?php echo htmlspecialchars($title ?? 'Home'); ?></title>
    <link rel="stylesheet" href="<?= BASE_URL . 'css/style.css' ?>">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<header class="site-header" id="siteHeader">
    <div class="header-inner container-wide">
        <a class="logo" href="<?= BASE_URL ?>home/index" aria-label="FoodFusion home">FoodFusion</a>

        <button class="menu-toggle" id="menuToggle" aria-expanded="false" aria-controls="primaryNav">☰</button>

        <nav id="primaryNav" class="primary-nav" aria-label="Primary">
            <a class="<?= isActive('home/index', $currentPath) ?>" href="<?= BASE_URL ?>home/index">Home</a>
            <a class="<?= isActive('home/about', $currentPath) ?>" href="<?= BASE_URL ?>home/about">About Us</a>
            <a class="<?= isActive('home/recipes', $currentPath) ?>" href="<?= BASE_URL ?>home/recipes">Recipe Collection</a>
            <a class="<?= isActive('home/community', $currentPath) ?>" href="<?= BASE_URL ?>home/community">Community Cookbook</a>
            <a class="<?= isActive('home/contact', $currentPath) ?>" href="<?= BASE_URL ?>home/contact">Contact Us</a>
            <a class="<?= isActive('home/culinary', $currentPath) ?>" href="<?= BASE_URL ?>home/culinary">Culinary Resources</a>
            <a class="<?= isActive('home/educational', $currentPath) ?>" href="<?= BASE_URL ?>home/educational">Educational Resources</a>
        </nav>

        <div class="header-tools">
            <form class="header-search" role="search" aria-label="Search recipes and resources">
                <label class="sr-only" for="globalSearch">Search recipes and resources</label>
                <input id="globalSearch" type="search" placeholder="Search recipes + resources">
            </form>
            <button id="themeToggle" class="icon-btn" aria-label="Toggle dark mode" type="button">◐</button>
            <button class="btn btn-accent" id="joinUsTrigger" type="button" aria-haspopup="dialog">Join Us</button>
        </div>
    </div>
</header>
