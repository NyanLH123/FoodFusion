<?php
$base = rtrim((string) ($appConfig['base_url'] ?? ''), '/');
$userInbox = $userInbox ?? [];
$userReplies = $userReplies ?? [];
?>
<section class="ff-section">
  <div class="container">
    <div class="row g-5 justify-content-center">

      <div class="col-lg-7">
        <span class="ff-section-label">Get in touch</span>
        <h1 class="ff-section-title">Contact us</h1>
        <p style="color:var(--ff-gray-600);margin-bottom:2rem">Have a question, feedback, or partnership enquiry? Fill in the form and we will get back to you.</p>

        <?php if (!empty($success)): ?>
          <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:var(--ff-radius-md);padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;color:#166534">
            Your message has been sent. We will be in touch soon.
          </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
          <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:var(--ff-radius-md);padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:.875rem;color:#991b1b">
            <?= htmlspecialchars((string) $error, ENT_QUOTES, 'UTF-8') ?>
          </div>
        <?php endif; ?>

        <div class="ff-card">
          <div class="ff-card-body" style="padding:2rem">
            <form method="post" class="d-flex flex-column gap-3">
              <div>
                <label class="ff-form-label">Your name</label>
                <input class="ff-input" name="name" required value="<?= htmlspecialchars(trim((string) ($currentUser['firstname'] ?? '') . ' ' . (string) ($currentUser['lastname'] ?? '')), ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div>
                <label class="ff-form-label">Email address</label>
                <input type="email" class="ff-input" name="email" required value="<?= htmlspecialchars((string) ($currentUser['email'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
              </div>
              <div>
                <label class="ff-form-label">Subject</label>
                <input class="ff-input" name="subject" placeholder="What is this about?" required>
              </div>
              <div>
                <label class="ff-form-label">Message</label>
                <textarea class="ff-textarea" name="message" placeholder="Tell us more..." rows="5" required></textarea>
              </div>
              <div>
                <button class="btn-ff-primary" type="submit" style="border:none">Send message</button>
              </div>
            </form>
          </div>
        </div>

        <?php if (Auth::check()): ?>
          <div class="ff-card" style="margin-top:1.25rem">
            <div class="ff-card-body" style="padding:1.4rem">
              <h2 style="font-size:1rem;margin-bottom:.9rem">Your message box</h2>
              <?php if (empty($userInbox)): ?>
                <p style="margin:0;color:var(--ff-gray-500)">No messages sent yet.</p>
              <?php else: ?>
                <div class="d-flex flex-column gap-3">
                  <?php foreach ($userInbox as $thread): ?>
                    <?php
                      $messageId = (int) ($thread['messageId'] ?? 0);
                      $threadReplies = $userReplies[$messageId] ?? [];
                    ?>
                    <article style="border:1px solid var(--ff-border);border-radius:var(--ff-radius-md);padding:.85rem .95rem;background:var(--ff-gray-50)">
                      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <strong style="font-size:.9rem"><?= htmlspecialchars((string) ($thread['subject'] ?? 'No subject'), ENT_QUOTES, 'UTF-8') ?></strong>
                        <span style="font-size:.72rem;color:var(--ff-gray-500)">
                          <?= htmlspecialchars(date('d M Y, H:i', strtotime((string) ($thread['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?>
                        </span>
                      </div>
                      <p style="font-size:.84rem;color:var(--ff-gray-600);margin:.55rem 0 .4rem;white-space:pre-line">
                        <?= htmlspecialchars((string) ($thread['message'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                      </p>
                      <div style="font-size:.72rem;color:var(--ff-gray-500);margin-bottom:.45rem;text-transform:uppercase;letter-spacing:.04em">
                        Status: <?= htmlspecialchars((string) ($thread['status'] ?? 'new'), ENT_QUOTES, 'UTF-8') ?>
                      </div>

                      <div style="border-top:1px solid var(--ff-border);padding-top:.55rem">
                        <p style="font-size:.72rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:var(--ff-gray-500);margin-bottom:.45rem">Admin replies</p>
                        <?php if (empty($threadReplies)): ?>
                          <p style="margin:0;font-size:.82rem;color:var(--ff-gray-500)">No reply yet.</p>
                        <?php else: ?>
                          <div class="d-flex flex-column gap-2">
                            <?php foreach ($threadReplies as $reply): ?>
                              <div style="background:#fff;border:1px solid var(--ff-border);border-radius:var(--ff-radius);padding:.5rem .65rem">
                                <div style="font-size:.72rem;color:var(--ff-gray-500);margin-bottom:.2rem">
                                  <?= htmlspecialchars(trim((string) ($reply['firstname'] ?? '') . ' ' . (string) ($reply['lastname'] ?? '')) ?: 'Admin', ENT_QUOTES, 'UTF-8') ?>
                                  &middot; <?= htmlspecialchars(date('d M Y, H:i', strtotime((string) ($reply['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?>
                                </div>
                                <div style="font-size:.84rem;color:var(--ff-gray-600);white-space:pre-line"><?= htmlspecialchars((string) ($reply['reply'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-4 col-xl-3">
        <div style="padding-top:3.5rem">
          <div style="margin-bottom:2rem">
            <p style="font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ff-gray-400);margin-bottom:.5rem">Email</p>
            <p style="font-size:.9rem;color:var(--ff-gray-700);margin:0">hello@foodfusion.com</p>
          </div>
          <div style="margin-bottom:2rem">
            <p style="font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ff-gray-400);margin-bottom:.5rem">Response time</p>
            <p style="font-size:.9rem;color:var(--ff-gray-700);margin:0">Within 2 business days</p>
          </div>
          <div>
            <p style="font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ff-gray-400);margin-bottom:.5rem">Community</p>
            <p style="font-size:.9rem;color:var(--ff-gray-700);margin:0">For quick help, try our <a href="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/cookbook/index" style="color:var(--ff-accent)">Community Cookbook</a>.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
