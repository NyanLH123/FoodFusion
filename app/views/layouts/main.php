<?php
$base      = rtrim((string) ($appConfig['base_url'] ?? ''), '/');
$pageTitle = isset($title) ? htmlspecialchars((string) $title, ENT_QUOTES, 'UTF-8') . ' — FoodFusion' : 'FoodFusion';
$uri       = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '/';
$cookieJsVersion = @filemtime(ROOT_PATH . '/public/js/cookie.js') ?: time();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="base-url" content="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>">
  <title><?= $pageTitle ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/css/theme.css" rel="stylesheet">
</head>
<body data-logged-in="<?= !empty($currentUser) ? '1' : '0' ?>">

<!-- ── Navigation ──────────────────────────────────────────────────────── -->
<nav class="ff-nav navbar navbar-expand-lg">
  <div class="container">
    <a class="ff-brand navbar-brand" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/">
      <img src="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/assets/logo.svg" alt="" class="ff-brand-mark">
      FoodFusion
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ffNav" aria-controls="ffNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="ffNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1 mt-3 mt-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index">Recipes</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index">Cookbook</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Resources</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/resources/culinary">Culinary</a></li>
            <li><a class="dropdown-item" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/resources/educational">Educational</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/contact/index">Contact</a></li>
        <li class="nav-item ms-lg-2">
          <?php if (!empty($currentUser)): ?>
            <div class="d-flex align-items-center gap-2">
              <a class="ff-btn-nav ff-btn-nav-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/profile/index">Profile</a>
              <?php if ((int) ($currentUser['role'] ?? 0) === 1): ?>
                <a class="ff-btn-nav ff-btn-nav-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/dashboard">Admin</a>
              <?php endif; ?>
              <a class="ff-btn-nav ff-btn-nav-solid" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/logout">Sign out</a>
            </div>
          <?php else: ?>
            <div class="d-flex align-items-center gap-2">
              <a class="ff-btn-nav ff-btn-nav-outline" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/login">Sign in</a>
              <a class="ff-btn-nav ff-btn-nav-solid" href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/register">Join free</a>
            </div>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ── Flash messages ───────────────────────────────────────────────────── -->
<?php if (!empty($flashSuccess) || !empty($flashError) || !empty($flashInfo)): ?>
<div class="container" style="padding-top:.75rem">
  <?php if (!empty($flashSuccess)): ?><div class="ff-alert ff-alert-success"><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
  <?php if (!empty($flashError)):   ?><div class="ff-alert ff-alert-error"><?= htmlspecialchars($flashError,   ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
  <?php if (!empty($flashInfo)):    ?><div class="ff-alert ff-alert-info"><?= htmlspecialchars($flashInfo,    ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
</div>
<?php endif; ?>

<main><?= $content ?></main>

<!-- ── Footer ──────────────────────────────────────────────────────────── -->
<footer class="ff-footer">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-lg-5">
        <span class="ff-footer-brand">FoodFusion</span>
        <p class="mb-0" style="max-width:320px;font-size:.85rem">A community-driven culinary platform for everyday cooks — recipes, resources, and real food stories.</p>
      </div>
      <div class="col-lg-2">
        <div class="ff-footer-heading">Navigate</div>
        <div class="d-flex flex-column gap-1">
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/recipe/index">Recipes</a>
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index">Cookbook</a>
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/about">About</a>
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/contact/index">Contact</a>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="ff-footer-heading">Legal</div>
        <div class="d-flex flex-column gap-1">
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/privacy">Privacy Policy</a>
          <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookies">Cookie Policy</a>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="ff-footer-heading">Follow us</div>
        <div class="d-flex gap-2">
          <a href="https://facebook.com"  target="_blank" rel="noopener noreferrer" class="ff-social-icon"><i class="bi bi-facebook"></i></a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="ff-social-icon"><i class="bi bi-instagram"></i></a>
          <a href="https://youtube.com"   target="_blank" rel="noopener noreferrer" class="ff-social-icon"><i class="bi bi-youtube"></i></a>
          <a href="https://twitter.com"   target="_blank" rel="noopener noreferrer" class="ff-social-icon"><i class="bi bi-twitter-x"></i></a>
        </div>
      </div>
    </div>
    <div class="ff-divider" style="margin:0 0 1.25rem"></div>
    <p class="mb-0" style="font-size:.78rem;color:var(--ff-gray-400)">&copy; <?= date('Y') ?> FoodFusion. NCC Education | Back End Web Development [2183-1].</p>
  </div>
</footer>

<!-- ── Cookie consent banner ───────────────────────────────────────────── -->
<div id="cookieConsentBanner" class="cookie-banner d-none">
  <p class="mb-2" style="line-height:1.5">We use cookies to improve your experience. <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookies">Learn more</a></p>
  <div class="d-flex gap-2">
    <button id="cookieAccept" class="btn-ff-accent btn-ff-sm" style="border-radius:var(--ff-radius-md);border:none;padding:.3rem .8rem;font-weight:700;cursor:pointer;font-size:.78rem">Accept</button>
    <button id="cookieDecline" style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.2);border-radius:var(--ff-radius-md);padding:.3rem .8rem;font-weight:700;cursor:pointer;font-size:.78rem">Decline</button>
  </div>
</div>

<!-- ── Join Us modal ────────────────────────────────────────────────────── -->
<div class="modal fade" id="joinUsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title">Join FoodFusion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p style="font-size:.85rem;color:var(--ff-gray-600);margin-bottom:1.25rem">Create a free account to share recipes, comment, and save your favourites.</p>
        <div id="joinUsFeedback" class="ff-alert d-none"></div>
        <form id="joinUsForm" method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/register">
          <div class="row g-2">
            <div class="col-6">
              <label class="ff-form-label">First name</label>
              <input name="firstname" class="ff-input" required>
            </div>
            <div class="col-6">
              <label class="ff-form-label">Last name</label>
              <input name="lastname" class="ff-input" required>
            </div>
            <div class="col-12">
              <label class="ff-form-label">Email</label>
              <input type="email" name="email" class="ff-input" required>
            </div>
            <div class="col-12">
              <label class="ff-form-label">Password <span style="font-weight:400;color:var(--ff-gray-400)">(min 8 chars)</span></label>
              <input type="password" name="password" class="ff-input" minlength="8" required>
            </div>
          </div>
          <button class="btn-ff-primary w-100 mt-3 text-center" type="submit" style="border:none">Create account</button>
        </form>
        <p style="font-size:.8rem;color:var(--ff-gray-400);margin-top:.75rem;margin-bottom:0">Already have an account? <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/login">Sign in</a></p>
      </div>
    </div>
  </div>
</div>

<script>window.FF_BASE = '<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>';</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/js/main.js"></script>
<script src="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/js/cookie.js?v=<?= (int) $cookieJsVersion ?>"></script>
</body>
</html>
