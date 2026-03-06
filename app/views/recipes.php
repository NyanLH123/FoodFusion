<?php include 'layouts/header.php'; ?>

<div class="container">
    <h1>Recipe Collection</h1>
    <p>Browse our diverse recipes categorized by cuisine, diet, and difficulty.</p>
    
    <div class="filters">
        <button>Cuisine Type</button>
        <button>Dietary Preferences</button>
        <button>Cooking Difficulty</button>
    </div>

    <div class="recipe-list">
        <div class="recipe-item">
            <h3>Thai Green Curry</h3>
            <p>Difficulty: Medium | Cuisine: Asian</p>
        </div>
        <div class="recipe-item">
            <h3>Caesar Salad</h3>
            <p>Difficulty: Easy | Cuisine: American</p>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>