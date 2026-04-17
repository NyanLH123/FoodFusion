<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>

<!-- ── Hero ─────────────────────────────────────────────────────────────── -->
<section class="ff-hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="ff-hero-eyebrow">Community · Recipes · Resources</span>
        <h1>Cooking made<br>meaningful, together.</h1>
        <p class="lead">Discover practical recipes, share your food story, and build better habits in the kitchen — one meal at a time.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
          <a class="btn-ff-primary" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index">Browse recipes</a>
          <button class="btn-ff-outline" data-bs-toggle="modal" data-bs-target="#joinUsModal">Join the community</button>
        </div>
      </div>
      <div class="col-lg-6">
        <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1200&q=80"
             alt="Colourful healthy meal" class="ff-hero-img">
      </div>
    </div>
  </div>
</section>

<!-- ── News feed ─────────────────────────────────────────────────────────── -->
<section class="ff-section">
  <div class="container">
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-4">
      <div>
        <span class="ff-section-label">From the community</span>
        <h2 class="ff-section-title mb-0">Latest cookbook posts</h2>
      </div>
      <a class="btn-ff-outline btn-ff-sm" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index">View all</a>
    </div>
    <div class="row g-4">
      <?php foreach ($news as $item): ?>
        <div class="col-md-4">
          <article class="ff-card h-100">
            <div class="ff-card-body d-flex flex-column">
              <div class="ff-post-meta">
                <span class="ff-post-dot"></span>
                <?= htmlspecialchars((string) $item['firstname'] . ' ' . (string) $item['lastname'], ENT_QUOTES, 'UTF-8') ?>
                &middot;
                <?= htmlspecialchars(date('d M Y', strtotime((string) $item['created_at'])), ENT_QUOTES, 'UTF-8') ?>
              </div>
              <h3 class="h6 fw-bold mb-2"><?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8') ?></h3>
              <p class="mb-0" style="font-size:.855rem;color:var(--ff-gray-600);flex-grow:1"><?= htmlspecialchars(mb_substr((string) $item['content'], 0, 130), ENT_QUOTES, 'UTF-8') ?>…</p>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="ff-section" style="padding-top:0">
  <div class="container">
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-4">
      <div>
        <span class="ff-section-label">Featured recipes</span>
        <h2 class="ff-section-title mb-0">Recipe collection preview</h2>
      </div>
      <a class="btn-ff-outline btn-ff-sm" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index">Browse all recipes</a>
    </div>

    <?php if (empty($recipePreview)): ?>
      <p style="color:var(--ff-gray-400);margin:0">No recipes yet.</p>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($recipePreview as $recipe): ?>
          <div class="col-md-6 col-xl-4">
            <article class="ff-card h-100">
              <img src="<?= htmlspecialchars((string) (($recipe['image'] ?? '') !== '' ? $recipe['image'] : 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=800&q=80'), ENT_QUOTES, 'UTF-8') ?>"
                   alt="<?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?>"
                   class="ff-card-img">
              <div class="ff-card-body d-flex flex-column">
                <div class="d-flex gap-1 flex-wrap mb-2">
                  <span class="ff-tag ff-tag-green"><?= htmlspecialchars((string) $recipe['cuisine'], ENT_QUOTES, 'UTF-8') ?></span>
                  <span class="ff-tag"><?= htmlspecialchars((string) $recipe['cookingdifficulty'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <h3 class="h6 fw-bold mb-2"><?= htmlspecialchars((string) $recipe['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p style="font-size:.82rem;color:var(--ff-gray-500);margin-bottom:.75rem">
                  by <?= htmlspecialchars((string) $recipe['firstname'] . ' ' . (string) $recipe['lastname'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p style="font-size:.855rem;color:var(--ff-gray-600);flex-grow:1"><?= htmlspecialchars(mb_substr((string) $recipe['description'], 0, 110), ENT_QUOTES, 'UTF-8') ?>...</p>
                <a class="btn-ff-outline btn-ff-sm mt-2" href="<?= htmlspecialchars($base . '/recipe/show?id=' . (int) $recipe['recipeId'], ENT_QUOTES, 'UTF-8') ?>">View recipe</a>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<div class="container"><hr class="ff-divider"></div>

<!-- ── Events carousel ───────────────────────────────────────────────────── -->
<section class="ff-section" style="padding-top:0">
  <div class="container">
    <span class="ff-section-label">Upcoming</span>
    <h2 class="ff-section-title">Cooking events</h2>
    <div id="eventCarousel" class="carousel slide ff-carousel" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php foreach ($events as $idx => $event): ?>
          <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
            <img src="<?= htmlspecialchars((string) $event['img'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars((string) $event['title'], ENT_QUOTES, 'UTF-8') ?>">
            <div class="carousel-caption">
              <h5><?= htmlspecialchars((string) $event['title'], ENT_QUOTES, 'UTF-8') ?></h5>
              <p><?= htmlspecialchars((string) $event['text'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
      <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
    </div>
  </div>
</section>
