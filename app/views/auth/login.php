<?php
$base = rtrim((string) ($appConfig['base_url'] ?? ''), '/');

// Read and clear all login-specific session data (one-time use, like flash)
$loginFieldErrors    = (array)  Session::get('login_field_errors',  []);
$loginAttemptsBanner = (string) Session::get('login_attempts_banner', '');
$loginLockedSeconds  = (int)    Session::get('login_locked_seconds',  0);
Session::remove('login_field_errors');
Session::remove('login_attempts_banner');
Session::remove('login_locked_seconds');

$isLocked = $loginLockedSeconds > 0;
?>
<div style="min-height:80vh;display:flex;align-items:center;padding:3rem 0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-md-7 col-lg-5">
        <div style="text-align:center;margin-bottom:2rem">
          <span class="ff-section-label">Welcome back</span>
          <h1 style="font-size:1.8rem;margin:0">Sign in to FoodFusion</h1>
        </div>
        <div class="ff-card">
          <div class="ff-card-body" style="padding:2rem">

            <?php if ($isLocked): ?>
              <!-- ── Account locked state ─────────────────────────────── -->
              <div class="ff-alert ff-alert-error" style="margin-bottom:1.25rem">
                Account locked for 3 minutes after 3 failed attempts.<br>
                <span style="font-size:.85em;opacity:.85">
                  Try again in <strong id="lockCountdown"><?= $loginLockedSeconds ?></strong> second<?= $loginLockedSeconds === 1 ? '' : 's' ?>.
                </span>
              </div>
              <form method="post" class="d-flex flex-column gap-3">
                <div>
                  <label class="ff-form-label">Email address</label>
                  <input type="email" name="email" class="ff-input" required autofocus>
                </div>
                <div>
                  <label class="ff-form-label">Password</label>
                  <input type="password" name="password" class="ff-input" required>
                </div>
                <button id="loginBtn" class="btn-ff-primary text-center" type="submit"
                        style="border:none;margin-top:.5rem;opacity:.5;cursor:not-allowed"
                        disabled>
                  Sign in
                </button>
              </form>
              <script>
              (function () {
                var seconds  = <?= $loginLockedSeconds ?>;
                var el       = document.getElementById('lockCountdown');
                var btn      = document.getElementById('loginBtn');
                var interval = setInterval(function () {
                  seconds--;
                  if (seconds <= 0) {
                    clearInterval(interval);
                    el.closest('.ff-alert').remove();
                    btn.disabled = false;
                    btn.style.opacity  = '1';
                    btn.style.cursor   = 'pointer';
                  } else {
                    el.textContent = seconds;
                  }
                }, 1000);
              })();
              </script>

            <?php else: ?>
              <!-- ── Normal / attempts-warning state ────────────────── -->
              <?php if ($loginAttemptsBanner !== ''): ?>
                <div class="ff-alert ff-alert-error" style="margin-bottom:1.25rem">
                  <?= htmlspecialchars($loginAttemptsBanner, ENT_QUOTES, 'UTF-8') ?>
                </div>
              <?php endif; ?>

              <form method="post" class="d-flex flex-column gap-3">
                <div>
                  <label class="ff-form-label">Email address</label>
                  <input
                    type="email"
                    name="email"
                    class="ff-input<?= isset($loginFieldErrors['email']) ? ' is-invalid' : '' ?>"
                    required
                    autofocus
                  >
                  <?php if (isset($loginFieldErrors['email'])): ?>
                    <div style="color:#dc3545;font-size:.82rem;margin-top:.35rem">
                      <?= htmlspecialchars($loginFieldErrors['email'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>

                <div>
                  <label class="ff-form-label">Password</label>
                  <input
                    type="password"
                    name="password"
                    class="ff-input<?= isset($loginFieldErrors['password']) ? ' is-invalid' : '' ?>"
                    required
                  >
                  <?php if (isset($loginFieldErrors['password'])): ?>
                    <div style="color:#dc3545;font-size:.82rem;margin-top:.35rem">
                      <?= htmlspecialchars($loginFieldErrors['password'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                  <?php endif; ?>
                </div>

                <button class="btn-ff-primary text-center" type="submit" style="border:none;margin-top:.5rem">Sign in</button>
              </form>

            <?php endif; ?>

            <p style="font-size:.82rem;color:var(--ff-gray-400);text-align:center;margin-top:1.25rem;margin-bottom:0">
              No account yet? <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/register">Create one free</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
