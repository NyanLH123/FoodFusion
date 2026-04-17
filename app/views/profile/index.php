<?php
$base = rtrim((string) ($appConfig['base_url'] ?? ''), '/');
$profile = $user ?? [];
$uploadedRecipes = $uploadedRecipes ?? [];
$uploadedCookbook = $uploadedCookbook ?? [];
$sharedCookbook = $sharedCookbook ?? [];
?>
<section class="ff-section">
  <div class="container" style="max-width:1100px">
    <span class="ff-section-label">Account</span>
    <h1 class="ff-section-title" style="margin-bottom:1.25rem">My profile</h1>

    <div class="row g-4 mb-4">
      <div class="col-lg-6">
        <div class="ff-card h-100">
          <div class="ff-card-body" style="padding:1.5rem">
            <h2 style="font-size:1.05rem;margin-bottom:1rem">Your uploaded recipes</h2>
            <?php if (empty($uploadedRecipes)): ?>
              <p style="margin:0;color:var(--ff-gray-500)">No recipes uploaded yet.</p>
            <?php else: ?>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($uploadedRecipes as $item): ?>
                  <?php
                    $recipeImage = (string) ($item['image'] ?? '');
                    $recipeImageUrl = ($recipeImage !== '' && preg_match('#^https?://#', $recipeImage))
                      ? $recipeImage
                      : (($recipeImage !== '') ? ($base . '/' . ltrim($recipeImage, '/')) : 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?auto=format&fit=crop&w=800&q=80');
                  ?>
                  <a href="<?= htmlspecialchars($base . '/recipe/show?id=' . (int) $item['recipeId'], ENT_QUOTES, 'UTF-8') ?>"
                     class="ff-list-item" style="text-decoration:none">
                    <div class="ff-list-thumb-wrap">
                      <img src="<?= htmlspecialchars($recipeImageUrl, ENT_QUOTES, 'UTF-8') ?>"
                           alt="<?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8') ?>"
                           class="ff-list-thumb">
                    </div>
                    <div style="min-width:0">
                      <div style="font-weight:700;color:var(--ff-black)"><?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div style="font-size:.8rem;color:var(--ff-gray-500)">
                        <?= htmlspecialchars((string) $item['cuisine'], ENT_QUOTES, 'UTF-8') ?>
                        &middot; <?= htmlspecialchars((string) $item['cookingdifficulty'], ENT_QUOTES, 'UTF-8') ?>
                        &middot; <?= htmlspecialchars(date('d M Y', strtotime((string) $item['created_at'])), ENT_QUOTES, 'UTF-8') ?>
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="ff-card h-100">
          <div class="ff-card-body" style="padding:1.5rem">
            <h2 style="font-size:1.05rem;margin-bottom:1rem">Your cookbook posts</h2>
            <?php if (empty($uploadedCookbook)): ?>
              <p style="margin:0;color:var(--ff-gray-500)">No cookbook posts uploaded yet.</p>
            <?php else: ?>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($uploadedCookbook as $post): ?>
                  <?php
                    $cookbookImage = (string) ($post['image'] ?? '');
                    $cookbookImageUrl = ($cookbookImage !== '' && preg_match('#^https?://#', $cookbookImage))
                      ? $cookbookImage
                      : (($cookbookImage !== '') ? ($base . '/' . ltrim($cookbookImage, '/')) : 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=700&q=80');
                  ?>
                  <a href="<?= htmlspecialchars($base . '/cookbook/index#post-' . (int) $post['postId'], ENT_QUOTES, 'UTF-8') ?>"
                     class="ff-list-item" style="text-decoration:none">
                    <div class="ff-list-thumb-wrap">
                      <img src="<?= htmlspecialchars($cookbookImageUrl, ENT_QUOTES, 'UTF-8') ?>"
                           alt="<?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?>"
                           class="ff-list-thumb">
                    </div>
                    <div style="min-width:0">
                      <div style="font-weight:700;color:var(--ff-black)"><?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div style="font-size:.8rem;color:var(--ff-gray-500)">
                        <?= htmlspecialchars(mb_substr((string) $post['content'], 0, 70), ENT_QUOTES, 'UTF-8') ?>...
                      </div>
                      <div style="font-size:.74rem;color:var(--ff-gray-500)">
                        <?= htmlspecialchars(date('d M Y', strtotime((string) $post['created_at'])), ENT_QUOTES, 'UTF-8') ?>
                        &middot; Interactions <?= (int) ($post['totalInteraction'] ?? 0) ?>
                        &middot; Shares <?= (int) ($post['totalshare'] ?? 0) ?>
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-12">
        <div class="ff-card">
          <div class="ff-card-body" style="padding:1.5rem">
            <h2 style="font-size:1.05rem;margin-bottom:1rem">Posts you shared</h2>
            <?php if (empty($sharedCookbook)): ?>
              <p style="margin:0;color:var(--ff-gray-500)">You have not shared a community post yet.</p>
            <?php else: ?>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($sharedCookbook as $post): ?>
                  <?php
                    $sharedImage = (string) ($post['image'] ?? '');
                    $sharedImageUrl = ($sharedImage !== '' && preg_match('#^https?://#', $sharedImage))
                      ? $sharedImage
                      : (($sharedImage !== '') ? ($base . '/' . ltrim($sharedImage, '/')) : 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=700&q=80');
                  ?>
                  <a href="<?= htmlspecialchars($base . '/cookbook/index#post-' . (int) $post['postId'], ENT_QUOTES, 'UTF-8') ?>"
                     class="ff-list-item" style="text-decoration:none">
                    <div class="ff-list-thumb-wrap">
                      <img src="<?= htmlspecialchars($sharedImageUrl, ENT_QUOTES, 'UTF-8') ?>"
                           alt="<?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?>"
                           class="ff-list-thumb">
                    </div>
                    <div style="min-width:0">
                      <div style="font-weight:700;color:var(--ff-black)"><?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?></div>
                      <div style="font-size:.8rem;color:var(--ff-gray-500)">
                        by <?= htmlspecialchars(trim((string) ($post['firstname'] ?? '') . ' ' . (string) ($post['lastname'] ?? '')), ENT_QUOTES, 'UTF-8') ?>
                        &middot; Shared on <?= htmlspecialchars(date('d M Y', strtotime((string) ($post['shared_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?>
                      </div>
                      <div style="font-size:.78rem;color:var(--ff-gray-500)">
                        <?= htmlspecialchars(mb_substr((string) $post['content'], 0, 80), ENT_QUOTES, 'UTF-8') ?>...
                      </div>
                    </div>
                  </a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-8">
        <div class="ff-card">
          <div class="ff-card-body" style="padding:1.5rem">
            <h2 style="font-size:1.05rem;margin-bottom:1rem">Update account details</h2>
            <form method="post" class="d-flex flex-column gap-3">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="ff-form-label">First name</label>
                  <input class="ff-input" name="firstname" required value="<?= htmlspecialchars((string) ($profile['firstname'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="col-md-6">
                  <label class="ff-form-label">Last name</label>
                  <input class="ff-input" name="lastname" required value="<?= htmlspecialchars((string) ($profile['lastname'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="col-12">
                  <label class="ff-form-label">Email</label>
                  <input type="email" class="ff-input" name="email" required value="<?= htmlspecialchars((string) ($profile['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <div class="col-12">
                  <label class="ff-form-label">New password (optional)</label>
                  <input type="password" class="ff-input" name="password" minlength="8" placeholder="Leave blank to keep your current password">
                </div>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <button class="btn-ff-primary" type="submit" style="border:none">Save changes</button>
                <a class="btn-ff-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index">Go to cookbook</a>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="ff-card">
          <div class="ff-card-body" style="padding:1.5rem">
            <h2 style="font-size:1.05rem;margin-bottom:.75rem">Account info</h2>
            <div style="font-size:.9rem;color:var(--ff-gray-600)">
              <div style="margin-bottom:.45rem"><strong>Name:</strong> <?= htmlspecialchars(trim((string) ($profile['firstname'] ?? '') . ' ' . (string) ($profile['lastname'] ?? '')), ENT_QUOTES, 'UTF-8') ?></div>
              <div style="margin-bottom:.45rem"><strong>Email:</strong> <?= htmlspecialchars((string) ($profile['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
              <div><strong>Member since:</strong> <?= htmlspecialchars(date('d M Y', strtotime((string) ($profile['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
