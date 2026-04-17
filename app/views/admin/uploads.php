<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>

<!-- Upload form -->
<div class="ff-card mb-5">
  <div class="ff-card-body" style="padding:1.5rem">
    <h2 style="font-size:.9rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--ff-gray-400);margin-bottom:1rem">Upload new resource</h2>
    <form method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3"
          action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/uploads">
      <input type="hidden" name="action" value="upload">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="ff-form-label">Title</label>
          <input class="ff-input" name="title" required>
        </div>
        <div class="col-md-6">
          <label class="ff-form-label">Resource type</label>
          <select class="ff-select" name="type" id="resourceTypeSelect">
            <option value="pdf">PDF</option>
            <option value="infographic">Infographic (PDF)</option>
            <option value="video">Video (MP4)</option>
            <option value="image">Image</option>
            <option value="youtube">YouTube Video</option>
          </select>
        </div>

        <!-- File upload field — hidden when YouTube is selected -->
        <div class="col-md-6" id="fileUploadField">
          <label class="ff-form-label">File <span style="font-weight:400;color:var(--ff-gray-400)">(JPG, PNG, WEBP, MP4, PDF)</span></label>
          <input type="file" class="ff-input" name="resource_file" id="resourceFileInput"
                 accept=".pdf,.mp4,.jpg,.jpeg,.png,.webp"
                 style="padding:.4rem .75rem">
        </div>

        <!-- YouTube URL field — shown only when YouTube is selected -->
        <div class="col-md-6 d-none" id="youtubeUrlField">
          <label class="ff-form-label">YouTube URL</label>
          <input type="url" class="ff-input" name="youtube_url" id="youtubeUrlInput"
                 placeholder="https://www.youtube.com/watch?v=...">
          <div style="font-size:.75rem;color:var(--ff-gray-400);margin-top:.25rem">
            Paste the full YouTube video or playlist URL.
          </div>
        </div>

        <div class="col-12">
          <label class="ff-form-label">Description <span style="font-weight:400;color:var(--ff-gray-400)">(optional)</span></label>
          <input class="ff-input" name="description" placeholder="Brief description of this resource">
        </div>
      </div>
      <div>
        <button class="btn-ff-primary" type="submit" style="border:none">Upload</button>
      </div>
    </form>
  </div>
</div>

<!-- Resource list -->
<table class="ff-table">
  <thead>
    <tr><th>#</th><th>Title</th><th>Path / URL</th><th>Type</th><th>Date</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($resources as $res): ?>
      <tr>
        <td style="color:var(--ff-gray-400)"><?= (int) $res['resourceId'] ?></td>
        <td><?= htmlspecialchars(mb_substr((string) $res['title'], 0, 35), ENT_QUOTES, 'UTF-8') ?></td>
        <td style="color:var(--ff-gray-500);font-size:.78rem">
          <?php if ((string) $res['type'] === 'youtube'): ?>
            <i class="bi bi-youtube" style="color:#dc2626"></i>
            <?= htmlspecialchars(mb_substr((string) ($res['youtube_url'] ?? ''), 0, 40), ENT_QUOTES, 'UTF-8') ?>
          <?php else: ?>
            <?= htmlspecialchars(basename((string) $res['path']), ENT_QUOTES, 'UTF-8') ?>
          <?php endif; ?>
        </td>
        <td><span class="ff-tag"><?= htmlspecialchars((string) $res['type'], ENT_QUOTES, 'UTF-8') ?></span></td>
        <td style="color:var(--ff-gray-400);font-size:.78rem"><?= htmlspecialchars(date('d M Y', strtotime((string) $res['uploaded_at'])), ENT_QUOTES, 'UTF-8') ?></td>
        <td>
          <div class="d-flex gap-1">
            <a class="btn-ff-outline btn-ff-sm" style="text-decoration:none"
               href="<?= htmlspecialchars($base . '/resources/download?id=' . (int) $res['resourceId'], ENT_QUOTES, 'UTF-8') ?>">
              <i class="bi bi-<?= (string) $res['type'] === 'youtube' ? 'youtube' : 'download' ?>"></i>
            </a>
            <form method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/uploads"
                  style="display:inline" onsubmit="return confirm('Delete this resource?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="resourceId" value="<?= (int) $res['resourceId'] ?>">
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

<script>
(function () {
  var typeSelect      = document.getElementById('resourceTypeSelect');
  var fileField       = document.getElementById('fileUploadField');
  var youtubeField    = document.getElementById('youtubeUrlField');
  var fileInput       = document.getElementById('resourceFileInput');
  var youtubeInput    = document.getElementById('youtubeUrlInput');

  function toggle() {
    var isYoutube = typeSelect.value === 'youtube';
    fileField.classList.toggle('d-none', isYoutube);
    youtubeField.classList.toggle('d-none', !isYoutube);
    fileInput.required    = !isYoutube;
    youtubeInput.required = isYoutube;
  }

  typeSelect.addEventListener('change', toggle);
  toggle(); // run on load
})();
</script>
