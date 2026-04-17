<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>

<!-- Create recipe form -->
<div class="ff-card mb-5">
  <div class="ff-card-body" style="padding:1.5rem">
    <h2 style="font-size:.9rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--ff-gray-400);margin-bottom:1rem">Add new recipe</h2>
    <form method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3"
          action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/recipes">
      <input type="hidden" name="action" value="create">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="ff-form-label">Title</label>
          <input class="ff-input" name="title" required>
        </div>
        <div class="col-md-6">
          <label class="ff-form-label">Cuisine</label>
          <input class="ff-input" name="cuisine" required>
        </div>
        <div class="col-md-6">
          <label class="ff-form-label">Dietary</label>
          <input class="ff-input" name="dietary" required>
        </div>
        <div class="col-md-6">
          <label class="ff-form-label">Difficulty</label>
          <select class="ff-select" name="cookingdifficulty">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
          </select>
        </div>
        <div class="col-12">
          <label class="ff-form-label">Description</label>
          <textarea class="ff-textarea" name="description" rows="2" required></textarea>
        </div>
        <div class="col-12">
          <label class="ff-form-label">Instructions</label>
          <textarea class="ff-textarea" name="instructions" rows="4" required></textarea>
        </div>
        <div class="col-md-6">
          <label class="ff-form-label">Recipe image <span style="font-weight:400;color:var(--ff-gray-400)">(optional, max 5 MB)</span></label>
          <input type="file" class="ff-input" name="recipe_image" accept="image/jpeg,image/png,image/webp" style="padding:.4rem .75rem">
        </div>
      </div>
      <div>
        <button class="btn-ff-primary" type="submit" style="border:none">Save recipe</button>
      </div>
    </form>
  </div>
</div>

<!-- Recipe list -->
<table class="ff-table">
  <thead>
    <tr><th>#</th><th>Title</th><th>Cuisine</th><th>Difficulty</th><th>Author</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($recipes as $recipe): ?>
      <tr>
        <td style="color:var(--ff-gray-400)"><?= (int) $recipe['recipeId'] ?></td>
        <td><?= htmlspecialchars(mb_substr((string) $recipe['title'], 0, 40), ENT_QUOTES, 'UTF-8') ?></td>
        <td><span class="ff-tag ff-tag-green"><?= htmlspecialchars((string) $recipe['cuisine'], ENT_QUOTES, 'UTF-8') ?></span></td>
        <td>
          <?php $d = (string) $recipe['cookingdifficulty']; $dc = $d === 'Easy' ? 'ff-tag-green' : ($d === 'Medium' ? 'ff-tag-amber' : 'ff-tag-red'); ?>
          <span class="ff-tag <?= $dc ?>"><?= htmlspecialchars($d, ENT_QUOTES, 'UTF-8') ?></span>
        </td>
        <td style="color:var(--ff-gray-500)"><?= htmlspecialchars((string) $recipe['firstname'] . ' ' . (string) $recipe['lastname'], ENT_QUOTES, 'UTF-8') ?></td>
        <td>
          <div class="d-flex gap-1">
            <a class="btn-ff-outline btn-ff-sm" style="text-decoration:none"
               href="<?= htmlspecialchars($base . '/recipe/show?id=' . (int) $recipe['recipeId'], ENT_QUOTES, 'UTF-8') ?>">
              View
            </a>
            <form method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/recipes"
                  style="display:inline" onsubmit="return confirm('Delete this recipe?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="recipeId" value="<?= (int) $recipe['recipeId'] ?>">
              <button class="btn-ff-sm" type="submit"
                style="background:none;border:1px solid #fecaca;color:#dc2626;border-radius:var(--ff-radius-sm);padding:.2rem .6rem;font-size:.75rem;cursor:pointer">
                Delete
              </button>
            </form>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
