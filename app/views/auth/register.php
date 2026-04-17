<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<div style="min-height:80vh;display:flex;align-items:center;padding:3rem 0">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-md-8 col-lg-6">
        <div style="text-align:center;margin-bottom:2rem">
          <span class="ff-section-label">Get started</span>
          <h1 style="font-size:1.8rem;margin:0">Create your account</h1>
        </div>
        <div class="ff-card">
          <div class="ff-card-body" style="padding:2rem">
            <form method="post" class="d-flex flex-column gap-3">
              <div class="row g-3">
                <div class="col-6">
                  <label class="ff-form-label">First name</label>
                  <input name="firstname" class="ff-input" required autofocus>
                </div>
                <div class="col-6">
                  <label class="ff-form-label">Last name</label>
                  <input name="lastname" class="ff-input" required>
                </div>
              </div>
              <div>
                <label class="ff-form-label">Email address</label>
                <input type="email" name="email" class="ff-input" required>
              </div>
              <div>
                <label class="ff-form-label">Password <span style="font-weight:400;color:var(--ff-gray-400)">(min 8 characters)</span></label>
                <input type="password" name="password" class="ff-input" minlength="8" required>
              </div>
              <button class="btn-ff-primary text-center" type="submit" style="border:none;margin-top:.5rem">Create account</button>
            </form>
            <p style="font-size:.82rem;color:var(--ff-gray-400);text-align:center;margin-top:1.25rem;margin-bottom:0">
              Already registered? <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/auth/login">Sign in</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
