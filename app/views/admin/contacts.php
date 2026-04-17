<?php $replies = $replies ?? []; ?>
<?php if (empty($messages)): ?>
  <p style="color:var(--ff-gray-400);text-align:center;padding:3rem 0">No messages in the inbox.</p>
<?php else: ?>
  <div class="d-flex flex-column gap-3">
    <?php foreach ($messages as $msg): ?>
      <?php
        $messageId = (int) ($msg['messageId'] ?? 0);
        $thread = $replies[$messageId] ?? [];
      ?>
      <div class="ff-card">
        <div class="ff-card-body" style="padding:1.25rem 1.5rem">
          <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
            <div>
              <span style="font-size:.95rem;font-weight:600"><?= htmlspecialchars((string) $msg['subject'], ENT_QUOTES, 'UTF-8') ?></span>
              <span style="font-size:.78rem;color:var(--ff-gray-400);margin-left:.75rem">
                from
                <?php
                  $senderName = trim((string) ($msg['firstname'] ?? '') . ' ' . (string) ($msg['lastname'] ?? ''));
                  echo htmlspecialchars($senderName !== '' ? $senderName : 'Guest', ENT_QUOTES, 'UTF-8');
                  if (!empty($msg['user_email'])) {
                      echo ' &lt;' . htmlspecialchars((string) $msg['user_email'], ENT_QUOTES, 'UTF-8') . '&gt;';
                  }
                ?>
              </span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span style="font-size:.72rem;color:var(--ff-gray-500);text-transform:uppercase;letter-spacing:.04em;border:1px solid var(--ff-border);padding:.15rem .4rem;border-radius:var(--ff-radius)">
                <?= htmlspecialchars((string) ($msg['status'] ?? 'new'), ENT_QUOTES, 'UTF-8') ?>
              </span>
              <span style="font-size:.75rem;color:var(--ff-gray-400)">
                <?= htmlspecialchars(date('d M Y, H:i', strtotime((string) $msg['created_at'])), ENT_QUOTES, 'UTF-8') ?>
              </span>
            </div>
          </div>

          <p style="font-size:.875rem;color:var(--ff-gray-600);margin:0;white-space:pre-line"><?= htmlspecialchars((string) $msg['message'], ENT_QUOTES, 'UTF-8') ?></p>

          <?php if ($thread !== []): ?>
            <div style="margin-top:.95rem;border-top:1px solid var(--ff-border);padding-top:.85rem">
              <p style="font-size:.75rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;color:var(--ff-gray-400);margin-bottom:.5rem">Reply thread</p>
              <div class="d-flex flex-column gap-2">
                <?php foreach ($thread as $reply): ?>
                  <div style="background:var(--ff-gray-50);border:1px solid var(--ff-border);border-radius:var(--ff-radius-md);padding:.6rem .75rem">
                    <div style="font-size:.72rem;color:var(--ff-gray-500);margin-bottom:.25rem">
                      <?= htmlspecialchars(trim((string) ($reply['firstname'] ?? '') . ' ' . (string) ($reply['lastname'] ?? '')) ?: 'Admin', ENT_QUOTES, 'UTF-8') ?>
                      &middot;
                      <?= htmlspecialchars(date('d M Y, H:i', strtotime((string) ($reply['created_at'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <div style="font-size:.84rem;color:var(--ff-gray-600);white-space:pre-line"><?= htmlspecialchars((string) ($reply['reply'] ?? ''), ENT_QUOTES, 'UTF-8') ?></div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <div style="margin-top:.95rem;border-top:1px solid var(--ff-border);padding-top:.85rem">
            <?php if ((int) ($msg['userId'] ?? 0) > 0): ?>
              <form method="post" class="d-flex flex-column gap-2">
                <input type="hidden" name="action" value="reply">
                <input type="hidden" name="messageId" value="<?= $messageId ?>">
                <label class="ff-form-label" style="margin-bottom:0">Reply to user inbox</label>
                <textarea name="reply" class="ff-textarea" rows="3" placeholder="Write your reply to this user..." required></textarea>
                <div class="d-flex gap-2">
                  <button type="submit" class="btn-ff-primary btn-ff-sm" style="border:none">Send reply</button>
                  <?php if (!empty($msg['user_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars((string) $msg['user_email'], ENT_QUOTES, 'UTF-8') ?>?subject=Re: <?= htmlspecialchars((string) $msg['subject'], ENT_QUOTES, 'UTF-8') ?>"
                       class="btn-ff-outline btn-ff-sm" style="text-decoration:none">
                      <i class="bi bi-envelope"></i> Email instead
                    </a>
                  <?php endif; ?>
                </div>
              </form>
            <?php else: ?>
              <p style="margin:0;font-size:.82rem;color:var(--ff-gray-500)">Guest message. In-app reply is unavailable because this sender has no account.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
