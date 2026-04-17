<?php
$base      = rtrim((string) ($appConfig['base_url'] ?? ''), '/');
$pageTitle = isset($title) ? htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') . ' — FoodFusion Admin' : 'FoodFusion Admin';
$uri       = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/';
function adminActive(string $uri, string $seg): string {
    return str_contains($uri, $seg) ? ' active' : '';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/css/theme.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" style="min-height:100vh">

  <!-- ── Sidebar ── -->
  <aside class="ff-admin-sidebar" style="width:220px;flex-shrink:0">
    <div style="padding-bottom:1.5rem;border-bottom:1px solid rgba(255,255,255,.1);margin-bottom:1.25rem">
      <span class="ff-admin-logo">FoodFusion</span>
      <span class="ff-admin-sub">Admin Panel</span>
    </div>
    <nav class="d-flex flex-column">
      <a class="ff-admin-nav-link<?= adminActive($uri, '/admin/dashboard') ?>" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a class="ff-admin-nav-link<?= adminActive($uri, '/admin/users') ?>"     href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/users"><i class="bi bi-people"></i> Users</a>
      <a class="ff-admin-nav-link<?= adminActive($uri, '/admin/recipes') ?>"   href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/recipes"><i class="bi bi-journal-richtext"></i> Recipes</a>
      <a class="ff-admin-nav-link<?= adminActive($uri, '/admin/uploads') ?>"   href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/uploads"><i class="bi bi-cloud-upload"></i> Resources</a>
      <a class="ff-admin-nav-link<?= adminActive($uri, '/admin/contacts') ?>"  href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/contacts"><i class="bi bi-envelope"></i> Inbox</a>
      <div style="border-top:1px solid rgba(255,255,255,.1);margin:1rem 0"></div>
      <a class="ff-admin-nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/"><i class="bi bi-house"></i> Main site</a>
      <a class="ff-admin-nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/logout"><i class="bi bi-box-arrow-right"></i> Sign out</a>
    </nav>
  </aside>

  <!-- ── Content ── -->
  <main class="ff-admin-content flex-grow-1">
    <?php if (!empty($flashSuccess)): ?><div class="ff-alert ff-alert-success mb-3"><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php if (!empty($flashError)):   ?><div class="ff-alert ff-alert-error mb-3"><?= htmlspecialchars($flashError,   ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?php if (!empty($flashInfo)):    ?><div class="ff-alert ff-alert-info mb-3"><?= htmlspecialchars($flashInfo,    ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
    <?= $content ?>
  </main>
</div>

<script>window.FF_BASE = '<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>';</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/js/admin.js"></script>
</body>
</html>
