<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<section class="ff-section">
  <div class="container" style="max-width:900px">
    <span class="ff-section-label">Contribute</span>
    <h1 class="ff-section-title" style="margin-bottom:1rem">Share your recipe</h1>
    <p style="color:var(--ff-gray-500);margin-bottom:1.75rem">Upload your own recipe with an optional image so others can cook it too.</p>

    <div class="ff-card">
      <div class="ff-card-body" style="padding:1.5rem">
        <form method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="ff-form-label">Title</label>
              <input class="ff-input" name="title" required>
            </div>
            <div class="col-md-6">
              <label class="ff-form-label">Cuisine</label>
              <input class="ff-input" name="cuisine" placeholder="e.g. Italian" required>
            </div>
            <div class="col-md-6">
              <label class="ff-form-label">Dietary</label>
              <input class="ff-input" name="dietary" placeholder="e.g. Vegetarian" required>
            </div>
            <div class="col-md-6">
              <label class="ff-form-label">Difficulty</label>
              <select class="ff-select" name="cookingdifficulty" required>
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
              </select>
            </div>
            <div class="col-12">
              <label class="ff-form-label">Description</label>
              <textarea class="ff-textarea" name="description" rows="3" required></textarea>
            </div>
            <div class="col-12">
              <label class="ff-form-label">Instructions</label>
              <textarea class="ff-textarea" name="instructions" rows="6" placeholder="Step by step instructions..." required></textarea>
            </div>
            <div class="col-md-8">
              <label class="ff-form-label">Recipe image (optional)</label>
              <input type="file" class="ff-input" name="recipe_image" accept="image/jpeg,image/png,image/webp" style="padding:.45rem .75rem">
            </div>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <button class="btn-ff-primary" type="submit" style="border:none">Upload recipe</button>
            <a class="btn-ff-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index">Back to cookbook</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
