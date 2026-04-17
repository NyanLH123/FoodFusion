<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<section class="ff-section">
  <div class="container">
    <a class="btn-ff-outline btn-ff-sm mb-4 d-inline-flex align-items-center gap-1" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index" style="text-decoration:none">
      <i class="bi bi-arrow-left"></i> Back to recipes
    </a>
    <div class="row g-5">
      <div class="col-lg-5">
        <img src="<?= htmlspecialchars((string) ($recipe['image'] ?: 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80'), ENT_QUOTES, 'UTF-8') ?>"
             alt="<?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?>"
             style="width:100%;height:360px;object-fit:cover;border-radius:var(--ff-radius-md);border:1px solid var(--ff-border)">
      </div>
      <div class="col-lg-7">
        <div class="d-flex flex-wrap gap-1 mb-3">
          <span class="ff-tag ff-tag-green"><?= htmlspecialchars((string) $recipe['cuisine'], ENT_QUOTES, 'UTF-8') ?></span>
          <span class="ff-tag"><?= htmlspecialchars((string) $recipe['dietary'], ENT_QUOTES, 'UTF-8') ?></span>
          <?php
            $diff = (string) $recipe['cookingdifficulty'];
            $dtag = $diff === 'Easy' ? 'ff-tag-green' : ($diff === 'Medium' ? 'ff-tag-amber' : 'ff-tag-red');
          ?>
          <span class="ff-tag <?= $dtag ?>"><?= htmlspecialchars($diff, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <h1 style="font-size:2rem;margin-bottom:.5rem"><?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p style="font-size:.82rem;color:var(--ff-gray-400);margin-bottom:1.25rem">
          Recipe by <?= htmlspecialchars((string) $recipe['firstname'] . ' ' . (string) $recipe['lastname'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <p style="color:var(--ff-gray-600)"><?= htmlspecialchars((string) $recipe['description'], ENT_QUOTES, 'UTF-8') ?></p>

        <!-- Ingredients -->
        <?php if (!empty($ingredients)): ?>
          <div class="ff-card mt-4">
            <div class="ff-card-body">
              <h2 style="font-size:1rem;margin-bottom:.75rem">Ingredients</h2>
              <div style="display:flex;flex-direction:column;gap:.35rem">
                <?php foreach ($ingredients as $ing): ?>
                  <div style="display:flex;justify-content:space-between;font-size:.875rem;padding:.4rem 0;border-bottom:1px solid var(--ff-border)">
                    <span><?= htmlspecialchars((string) $ing['name'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span style="color:var(--ff-gray-400)"><?= htmlspecialchars((string) $ing['amount'] . ' ' . (string) $ing['unit'], ENT_QUOTES, 'UTF-8') ?></span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Instructions -->
    <div class="ff-card mt-5">
      <div class="ff-card-body">
        <h2 style="font-size:1.1rem;margin-bottom:1rem">Instructions</h2>
        <p style="white-space:pre-line;color:var(--ff-gray-600);margin:0;line-height:1.9"><?= htmlspecialchars((string) $recipe['instructions'], ENT_QUOTES, 'UTF-8') ?></p>
      </div>
    </div>
  </div>
</section>
