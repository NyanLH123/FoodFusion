<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<?php $interactionState = $interactionState ?? []; ?>
<section class="ff-section">
  <div class="container">
    <span class="ff-section-label">Community</span>
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-4">
      <h1 class="ff-section-title mb-0">Community cookbook</h1>
      <?php if (!empty($currentUser)): ?>
        <span class="ff-tag ff-tag-green"><?= htmlspecialchars((string) $currentUser['firstname'], ENT_QUOTES, 'UTF-8') ?></span>
      <?php endif; ?>
    </div>

    <!-- Submit form (logged in only) -->
    <?php if (Auth::check()): ?>
      <div class="ff-card mb-5">
        <div class="ff-card-body" style="padding:1.5rem">
          <h2 style="font-size:1rem;margin-bottom:1rem">Share your story with an image</h2>
          <form method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
            <div>
              <label class="ff-form-label">Title</label>
              <input class="ff-input" name="title" placeholder="Give your post a title" required>
            </div>
            <div>
              <label class="ff-form-label">Your story or tip</label>
              <textarea class="ff-textarea" name="content" placeholder="What have you cooked, learned or discovered?" required></textarea>
            </div>
            <div>
              <label class="ff-form-label">Image (optional)</label>
              <input type="file" class="ff-input" name="image" accept="image/jpeg,image/png,image/webp" style="padding:.45rem .75rem">
            </div>
            <div>
              <button class="btn-ff-primary" type="submit" style="border:none">Publish post</button>
            </div>
          </form>
        </div>
      </div>
    <?php else: ?>
      <div style="background:var(--ff-gray-50);border:1px solid var(--ff-border);border-radius:var(--ff-radius-md);padding:1rem 1.25rem;margin-bottom:2.5rem;font-size:.875rem;color:var(--ff-gray-600)">
        <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/login">Sign in</a> or <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/register">join free</a> to post, comment, and like community content.
      </div>
    <?php endif; ?>

    <!-- Posts -->
    <div class="row g-4">
      <?php foreach ($posts as $post): ?>
        <?php
          $postId = (int) $post['postId'];
          $isLiked = !empty($interactionState[$postId]['liked']);
          $isShared = !empty($interactionState[$postId]['shared']);
        ?>
        <div class="col-lg-6" id="post-<?= $postId ?>">
          <article class="ff-post-card h-100 d-flex flex-column" data-post-card data-post-id="<?= $postId ?>">
            <div class="ff-post-meta">
              <span class="ff-post-dot"></span>
              <?= htmlspecialchars((string) $post['firstname'] . ' ' . (string) $post['lastname'], ENT_QUOTES, 'UTF-8') ?>
              &middot;
              <?= htmlspecialchars(date('d M Y', strtotime((string) $post['created_at'])), ENT_QUOTES, 'UTF-8') ?>
            </div>
            <?php if (!empty($post['image'])): ?>
              <?php $postImage = (string) $post['image']; ?>
              <?php $postImageUrl = preg_match('#^https?://#', $postImage) ? $postImage : ($base . '/' . ltrim($postImage, '/')); ?>
              <img src="<?= htmlspecialchars($postImageUrl, ENT_QUOTES, 'UTF-8') ?>"
                   alt="<?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?>"
                   style="width:100%;height:220px;object-fit:cover;border-radius:var(--ff-radius-sm);border:1px solid var(--ff-border);margin-bottom:.85rem">
            <?php endif; ?>
            <h2 style="font-size:1.05rem;margin-bottom:.5rem"><?= htmlspecialchars((string) $post['title'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p style="font-size:.875rem;color:var(--ff-gray-600);flex-grow:1"><?= htmlspecialchars((string) $post['content'], ENT_QUOTES, 'UTF-8') ?></p>

            <!-- Interaction bar -->
            <div class="ff-interact-bar">
              <?php if (Auth::check()): ?>
                <button class="ff-interact-btn js-like-btn<?= $isLiked ? ' is-active' : '' ?>"
                        data-post-id="<?= $postId ?>"
                        data-liked="<?= $isLiked ? '1' : '0' ?>"
                        aria-pressed="<?= $isLiked ? 'true' : 'false' ?>">
                  <i class="bi <?= $isLiked ? 'bi-heart-fill' : 'bi-heart' ?> js-like-icon"></i>
                  <span class="js-like-label"><?= $isLiked ? 'Liked' : 'Like' ?></span>
                </button>
                <button class="ff-interact-btn js-share-btn<?= $isShared ? ' is-active' : '' ?>"
                        data-post-id="<?= $postId ?>"
                        data-shared="<?= $isShared ? '1' : '0' ?>"
                        aria-pressed="<?= $isShared ? 'true' : 'false' ?>"
                        <?= $isShared ? 'disabled' : '' ?>
                        data-share-url="<?= htmlspecialchars($base . '/cookbook/index#post-' . $postId, ENT_QUOTES, 'UTF-8') ?>">
                  <i class="bi <?= $isShared ? 'bi-share-fill' : 'bi-share' ?> js-share-icon"></i>
                  <span class="js-share-label"><?= $isShared ? 'Shared' : 'Share' ?></span>
                </button>
              <?php endif; ?>
              <span style="font-size:.75rem;color:var(--ff-gray-400);margin-left:auto;display:flex;gap:.75rem;align-items:center">
                <span><i class="bi bi-heart-fill" style="color:#e63946;font-size:.7rem"></i> <span class="js-like-count"><?= (int) $post['totalInteraction'] ?></span></span>
                <span><i class="bi bi-share-fill" style="font-size:.7rem"></i> <span class="js-share-count"><?= (int) $post['totalshare'] ?></span></span>
              </span>
            </div>

            <!-- Comments -->
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--ff-border)">
              <p style="font-size:.75rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:var(--ff-gray-400);margin-bottom:.5rem">Comments</p>
              <div class="ff-comment-list js-comments" data-post-id="<?= (int) $post['postId'] ?>">
                <span style="font-size:.82rem;color:var(--ff-gray-400)">Loading...</span>
              </div>
              <?php if (Auth::check()): ?>
                <form class="js-comment-form d-flex gap-2 mt-2" data-post-id="<?= (int) $post['postId'] ?>">
                  <input class="ff-input" name="message" placeholder="Write a comment..." style="flex:1" required>
                  <button class="btn-ff-accent btn-ff-sm" type="submit" style="border:none;white-space:nowrap">Send</button>
                </form>
              <?php endif; ?>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

