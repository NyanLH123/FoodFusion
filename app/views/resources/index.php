<?php
$base       = rtrim((string) ($appConfig['base_url'] ?? ''), '/');
$isCulinary = ($pageType ?? '') === 'culinary';
$label      = $isCulinary ? 'Kitchen Knowledge' : 'Learning Hub';
$heading    = $isCulinary ? 'Culinary resources' : 'Educational resources';
$sub        = $isCulinary
  ? 'Technique guides, ingredient references, and flavour maps for curious cooks.'
  : 'Lesson plans, food-science articles, and study materials for students and educators.';

/**
 * Extract the embed-ready YouTube video ID from any standard YouTube URL.
 * Supports: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID,
 *           youtube.com/shorts/ID, and ?si= sharing params.
 */
function extractYoutubeId(string $url): string
{
    if (preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $url, $m)) {
        return $m[1];
    }
    if (preg_match('#(?:v=|/embed/|/shorts/)([a-zA-Z0-9_-]{11})#', $url, $m)) {
        return $m[1];
    }
    return '';
}
?>
<section class="ff-section">
  <div class="container">
    <span class="ff-section-label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
    <div class="d-flex justify-content-between align-items-baseline flex-wrap gap-2 mb-2">
      <h1 class="ff-section-title mb-0"><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>
    </div>
    <p style="color:var(--ff-gray-500);margin-bottom:2rem;font-size:.9rem"><?= htmlspecialchars($sub, ENT_QUOTES, 'UTF-8') ?></p>

    <!-- Tab switcher -->
    <div class="d-flex gap-2 mb-4">
      <a class="ff-tag <?= $isCulinary ? 'ff-tag-green' : '' ?>"
         href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/resources/culinary"
         style="text-decoration:none;cursor:pointer">Culinary</a>
      <a class="ff-tag <?= !$isCulinary ? 'ff-tag-green' : '' ?>"
         href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/resources/educational"
         style="text-decoration:none;cursor:pointer">Educational</a>
    </div>

    <?php if (empty($resources)): ?>
      <p style="color:var(--ff-gray-400);text-align:center;padding:3rem 0">No resources available yet. Check back soon.</p>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($resources as $res):
          $resId      = (int) $res['resourceId'];
          $resType    = (string) $res['type'];
          $resTitle   = (string) $res['title'];
          $resDesc    = (string) ($res['description'] ?? '');
          $resDate    = date('d M Y', strtotime((string) $res['uploaded_at']));
          $path       = (string) $res['path'];
          $youtubeUrl = (string) ($res['youtube_url'] ?? '');
          $youtubeId  = $resType === 'youtube' ? extractYoutubeId($youtubeUrl) : '';

          $fileUrl = preg_match('#^https?://#', $path)
            ? $path
            : $base . '/' . ltrim($path, '/');

          $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

          $isImage = $resType === 'image' || in_array($ext, ['jpg','jpeg','png','webp','gif'], true);
          $isVideo = $resType === 'video' || in_array($ext, ['mp4','webm','ogg'], true);
          $isPdf   = in_array($resType, ['pdf','infographic'], true) || $ext === 'pdf';
          $canPreview = $resType === 'youtube' ? $youtubeId !== '' : ($isImage || $isVideo || $isPdf);

          $typeIcons = [
            'pdf'         => ['icon' => 'bi-file-earmark-pdf',       'label' => 'PDF',         'color' => '#dc2626'],
            'infographic' => ['icon' => 'bi-file-earmark-bar-graph',  'label' => 'Infographic', 'color' => '#7c3aed'],
            'video'       => ['icon' => 'bi-play-circle-fill',        'label' => 'Video',       'color' => '#0284c7'],
            'image'       => ['icon' => 'bi-image',                   'label' => 'Image',       'color' => '#059669'],
            'youtube'     => ['icon' => 'bi-youtube',                 'label' => 'YouTube',     'color' => '#dc2626'],
          ];
          $badge = $typeIcons[$resType] ?? ['icon' => 'bi-file-earmark', 'label' => strtoupper($ext ?: $resType), 'color' => 'var(--ff-gray-600)'];
        ?>
          <div class="col-md-6 col-xl-4">
            <div class="ff-card h-100 d-flex flex-column">
              <div class="ff-card-body d-flex flex-column" style="padding:1.25rem">

                <!-- ── Thumbnail ──────────────────────────────────── -->
                <div class="ff-res-thumb" style="margin-bottom:1rem">
                  <?php if ($resType === 'youtube' && $youtubeId !== ''): ?>
                    <button class="ff-res-thumb-btn" data-preview-id="<?= $resId ?>"
                            aria-label="Preview <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      <img src="https://img.youtube.com/vi/<?= htmlspecialchars($youtubeId, ENT_QUOTES, 'UTF-8') ?>/hqdefault.jpg"
                           alt="<?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>"
                           loading="lazy" style="width:100%;height:100%;object-fit:cover">
                      <span class="ff-res-play-overlay"><i class="bi bi-play-circle-fill"></i></span>
                    </button>

                  <?php elseif ($isImage): ?>
                    <button class="ff-res-thumb-btn" data-preview-id="<?= $resId ?>"
                            aria-label="Preview <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      <img src="<?= htmlspecialchars($fileUrl, ENT_QUOTES, 'UTF-8') ?>"
                           alt="<?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>"
                           loading="lazy" style="width:100%;height:100%;object-fit:cover">
                      <span class="ff-res-zoom-overlay"><i class="bi bi-zoom-in"></i></span>
                    </button>

                  <?php elseif ($isVideo): ?>
                    <button class="ff-res-thumb-btn" data-preview-id="<?= $resId ?>"
                            aria-label="Preview <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      <div class="ff-res-thumb-placeholder">
                        <i class="bi bi-play-circle" style="font-size:2.5rem;color:var(--ff-accent)"></i>
                        <span style="font-size:.78rem;color:var(--ff-gray-500);margin-top:.3rem">Click to play</span>
                      </div>
                    </button>

                  <?php elseif ($isPdf): ?>
                    <button class="ff-res-thumb-btn" data-preview-id="<?= $resId ?>"
                            aria-label="Preview <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      <div class="ff-res-thumb-placeholder">
                        <i class="bi bi-file-earmark-pdf" style="font-size:2.5rem;color:#dc2626"></i>
                        <span style="font-size:.78rem;color:var(--ff-gray-500);margin-top:.3rem">Click to preview</span>
                      </div>
                    </button>

                  <?php else: ?>
                    <div class="ff-res-thumb-placeholder" style="border-radius:var(--ff-radius-sm);border:1px solid var(--ff-border)">
                      <i class="bi bi-file-earmark" style="font-size:2rem;color:var(--ff-gray-400)"></i>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- ── Badge + title ──────────────────────────────── -->
                <div class="d-flex align-items-center gap-2 mb-2">
                  <i class="bi <?= htmlspecialchars($badge['icon'], ENT_QUOTES, 'UTF-8') ?>"
                     style="font-size:1.1rem;color:<?= htmlspecialchars($badge['color'], ENT_QUOTES, 'UTF-8') ?>"></i>
                  <span class="ff-tag" style="font-size:.65rem"><?= htmlspecialchars($badge['label'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>

                <h2 style="font-size:.95rem;font-weight:700;margin-bottom:.3rem;line-height:1.4;flex-grow:1">
                  <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>
                </h2>

                <?php if ($resDesc !== ''): ?>
                  <p style="font-size:.78rem;color:var(--ff-gray-500);margin-bottom:.5rem;line-height:1.5">
                    <?= htmlspecialchars($resDesc, ENT_QUOTES, 'UTF-8') ?>
                  </p>
                <?php endif; ?>

                <p style="font-size:.72rem;color:var(--ff-gray-400);margin-bottom:1rem">
                  <?= htmlspecialchars($resDate, ENT_QUOTES, 'UTF-8') ?>
                </p>

                <!-- ── Action buttons ─────────────────────────────── -->
                <div class="d-flex gap-2 mt-auto flex-wrap">
                  <?php if ($canPreview): ?>
                    <button class="btn-ff-outline btn-ff-sm d-inline-flex align-items-center gap-1"
                            data-preview-id="<?= $resId ?>">
                      <i class="bi bi-eye"></i> Preview
                    </button>
                  <?php endif; ?>

                  <?php if ($resType === 'youtube'): ?>
                    <a href="<?= htmlspecialchars($youtubeUrl, ENT_QUOTES, 'UTF-8') ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-ff-primary btn-ff-sm d-inline-flex align-items-center gap-1"
                       style="text-decoration:none">
                      <i class="bi bi-youtube"></i> Watch on YouTube
                    </a>
                  <?php else: ?>
                    <a href="<?= htmlspecialchars($base . '/resources/download?id=' . $resId, ENT_QUOTES, 'UTF-8') ?>"
                       class="btn-ff-primary btn-ff-sm d-inline-flex align-items-center gap-1"
                       style="text-decoration:none">
                      <i class="bi bi-download"></i> Download
                    </a>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>

          <!-- ── Preview Modal ───────────────────────────────────────────── -->
          <?php if ($canPreview): ?>
          <div class="modal fade ff-preview-modal" id="previewModal<?= $resId ?>"
               tabindex="-1" aria-hidden="true"
               data-res-type="<?= htmlspecialchars($resType, ENT_QUOTES, 'UTF-8') ?>">
            <div class="modal-dialog modal-xl modal-dialog-centered">
              <div class="modal-content" style="background:var(--ff-black);border:none;border-radius:var(--ff-radius-md);overflow:hidden">

                <div class="modal-header" style="border-bottom:1px solid rgba(255,255,255,.1);padding:.75rem 1.25rem">
                  <div>
                    <h5 class="modal-title" style="color:#fff;font-size:.95rem;margin:0">
                      <?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>
                    </h5>
                    <?php if ($resDesc !== ''): ?>
                      <p style="color:rgba(255,255,255,.5);font-size:.75rem;margin:.2rem 0 0">
                        <?= htmlspecialchars($resDesc, ENT_QUOTES, 'UTF-8') ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding:0;background:#111">
                  <?php if ($resType === 'youtube'): ?>
                    <!-- YouTube responsive embed — src set lazily via JS on modal open -->
                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden">
                      <iframe class="ff-lazy-yt"
                              data-src="https://www.youtube.com/embed/<?= htmlspecialchars($youtubeId, ENT_QUOTES, 'UTF-8') ?>?rel=0&autoplay=1"
                              style="position:absolute;top:0;left:0;width:100%;height:100%;border:none"
                              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                              allowfullscreen
                              title="<?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      </iframe>
                    </div>

                  <?php elseif ($isVideo): ?>
                    <video controls style="width:100%;max-height:75vh;display:block;background:#000">
                      <source src="<?= htmlspecialchars($fileUrl, ENT_QUOTES, 'UTF-8') ?>" type="video/mp4">
                      Your browser does not support video playback.
                    </video>

                  <?php elseif ($isPdf): ?>
                    <iframe src="<?= htmlspecialchars($fileUrl, ENT_QUOTES, 'UTF-8') ?>#toolbar=1&view=FitH"
                            style="width:100%;height:78vh;border:none;display:block"
                            title="<?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>">
                      <p style="color:#fff;padding:1rem">
                        PDF preview not supported in this browser.
                        <a href="<?= htmlspecialchars($base . '/resources/download?id=' . $resId, ENT_QUOTES, 'UTF-8') ?>"
                           style="color:var(--ff-accent)">Download the file instead.</a>
                      </p>
                    </iframe>

                  <?php elseif ($isImage): ?>
                    <img src="<?= htmlspecialchars($fileUrl, ENT_QUOTES, 'UTF-8') ?>"
                         alt="<?= htmlspecialchars($resTitle, ENT_QUOTES, 'UTF-8') ?>"
                         style="width:100%;max-height:82vh;object-fit:contain;display:block;background:#111">
                  <?php endif; ?>
                </div>

                <div class="modal-footer" style="border-top:1px solid rgba(255,255,255,.1);padding:.75rem 1.25rem;background:var(--ff-black)">
                  <?php if ($resType === 'youtube'): ?>
                    <a href="<?= htmlspecialchars($youtubeUrl, ENT_QUOTES, 'UTF-8') ?>"
                       target="_blank" rel="noopener noreferrer"
                       class="btn-ff-primary btn-ff-sm d-inline-flex align-items-center gap-1"
                       style="text-decoration:none">
                      <i class="bi bi-youtube"></i> Open on YouTube
                    </a>
                  <?php else: ?>
                    <a href="<?= htmlspecialchars($base . '/resources/download?id=' . $resId, ENT_QUOTES, 'UTF-8') ?>"
                       class="btn-ff-primary btn-ff-sm d-inline-flex align-items-center gap-1"
                       style="text-decoration:none">
                      <i class="bi bi-download"></i> Download
                    </a>
                  <?php endif; ?>
                  <button type="button" class="btn-ff-outline btn-ff-sm" data-bs-dismiss="modal"
                          style="color:rgba(255,255,255,.7);border-color:rgba(255,255,255,.2);background:transparent">
                    Close
                  </button>
                </div>

              </div>
            </div>
          </div>
          <?php endif; ?>

        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
(function () {
  // Wire all [data-preview-id] triggers (thumbnail buttons + Preview card buttons)
  document.querySelectorAll('[data-preview-id]').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      var id    = trigger.getAttribute('data-preview-id');
      var modal = document.getElementById('previewModal' + id);
      if (!modal) return;

      // Lazy-load YouTube iframes only when the modal first opens
      var yt = modal.querySelector('.ff-lazy-yt');
      if (yt && !yt.src) {
        yt.src = yt.getAttribute('data-src');
      }

      bootstrap.Modal.getOrCreateInstance(modal).show();
    });
  });

  // Stop playback when any preview modal closes
  document.querySelectorAll('.ff-preview-modal').forEach(function (modal) {
    modal.addEventListener('hide.bs.modal', function () {
      modal.querySelectorAll('video').forEach(function (v) { v.pause(); });
      var yt = modal.querySelector('.ff-lazy-yt');
      if (yt) { yt.src = ''; } // clears YouTube so it stops; will re-lazy-load on next open
    });
  });
})();
</script>
