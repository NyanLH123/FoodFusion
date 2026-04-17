<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<section class="ff-section">
  <div class="container">
    <span class="ff-section-label">Explore</span>
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-3">
      <h1 class="ff-section-title mb-0">Recipe collection</h1>
      <?php if (Auth::check()): ?>
        <a class="btn-ff-primary btn-ff-sm" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/create" style="border:none;text-decoration:none">Share recipe</a>
      <?php endif; ?>
    </div>

    <!-- Filter bar -->
    <form id="recipeFilterForm" method="get" class="ff-filter-bar">
      <select name="cuisine" class="ff-select" style="flex:1;min-width:140px">
        <option value="">All cuisines</option>
        <?php foreach ($options['cuisines'] as $item): ?>
          <?php $v = (string) $item['cuisine']; ?>
          <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= ($filters['cuisine'] ?? '') === $v ? 'selected' : '' ?>><?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></option>
        <?php endforeach; ?>
      </select>
      <select name="dietary" class="ff-select" style="flex:1;min-width:140px">
        <option value="">All dietary</option>
        <?php foreach ($options['dietary'] as $item): ?>
          <?php $v = (string) $item['dietary']; ?>
          <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= ($filters['dietary'] ?? '') === $v ? 'selected' : '' ?>><?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></option>
        <?php endforeach; ?>
      </select>
      <select name="cookingdifficulty" class="ff-select" style="flex:1;min-width:140px">
        <option value="">All difficulties</option>
        <?php foreach ($options['difficulties'] as $item): ?>
          <?php $v = (string) $item['cookingdifficulty']; ?>
          <option value="<?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?>" <?= ($filters['cookingdifficulty'] ?? '') === $v ? 'selected' : '' ?>><?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn-ff-primary btn-ff-sm" type="submit" style="border:none">Filter</button>
      <?php if (array_filter($filters)): ?>
        <a class="btn-ff-outline btn-ff-sm" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index">Clear</a>
      <?php endif; ?>
    </form>

    <!-- Recipe grid -->
    <?php if (empty($recipes)): ?>
      <p style="color:var(--ff-gray-400);text-align:center;padding:3rem 0">No recipes found for the selected filters.</p>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($recipes as $recipe): ?>
          <div class="col-md-6 col-xl-4">
            <article class="ff-card h-100">
              <img src="<?= htmlspecialchars((string) ($recipe['image'] ?: 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=800&q=80'), ENT_QUOTES, 'UTF-8') ?>"
                   alt="<?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?>" class="ff-card-img">
              <div class="ff-card-body d-flex flex-column">
                <div class="d-flex flex-wrap gap-1 mb-2">
                  <span class="ff-tag ff-tag-green"><?= htmlspecialchars((string) $recipe['cuisine'], ENT_QUOTES, 'UTF-8') ?></span>
                  <?php
                    $diff  = (string) $recipe['cookingdifficulty'];
                    $dtag  = $diff === 'Easy' ? 'ff-tag-green' : ($diff === 'Medium' ? 'ff-tag-amber' : 'ff-tag-red');
                  ?>
                  <span class="ff-tag <?= $dtag ?>"><?= htmlspecialchars($diff, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h2 class="h6 fw-bold mb-1"><?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p style="font-size:.78rem;color:var(--ff-gray-400);margin-bottom:.75rem">by <?= htmlspecialchars((string) $recipe['firstname'] . ' ' . (string) $recipe['lastname'], ENT_QUOTES, 'UTF-8') ?></p>
                <p style="font-size:.855rem;color:var(--ff-gray-600);flex-grow:1;margin-bottom:1rem"><?= htmlspecialchars(mb_substr((string) $recipe['description'], 0, 110), ENT_QUOTES, 'UTF-8') ?>…</p>
                <a class="btn-ff-outline btn-ff-sm" href="<?= htmlspecialchars($base . '/recipe/show?id=' . (int) $recipe['recipeId'], ENT_QUOTES, 'UTF-8') ?>">View recipe</a>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($pages > 1): ?>
      <nav class="ff-pagination" aria-label="Pagination">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
          <a class="ff-page-link <?= $i === $page ? 'active' : '' ?>"
             href="?page=<?= $i ?>&cuisine=<?= urlencode((string) ($filters['cuisine'] ?? '')) ?>&dietary=<?= urlencode((string) ($filters['dietary'] ?? '')) ?>&cookingdifficulty=<?= urlencode((string) ($filters['cookingdifficulty'] ?? '')) ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>
  </div>
</section>
