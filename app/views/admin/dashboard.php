<!-- Stats row -->
<div class="row g-3 mb-5">
  <?php
  $cards = [
    ['Users',    $stats['users'],    'bi-people',         '/admin/users'],
    ['Recipes',  $stats['recipes'],  'bi-journal-richtext','/admin/recipes'],
    ['Posts',    $stats['posts'],    'bi-chat-square-text','/admin/dashboard'],
    ['Messages', $stats['messages'], 'bi-envelope',       '/admin/contacts'],
  ];
  foreach ($cards as [$label, $count, $icon, $href]):
  ?>
    <div class="col-sm-6 col-xl-3">
      <a href="<?= htmlspecialchars((string) ($appConfig['base_url'] ?? ''), ENT_QUOTES, 'UTF-8') . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') ?>"
         style="text-decoration:none">
        <div class="ff-card" style="padding:1.25rem 1.5rem;display:flex;align-items:center;gap:1rem">
          <i class="bi <?= $icon ?>" style="font-size:1.5rem;color:var(--ff-accent);flex-shrink:0"></i>
          <div>
            <div style="font-size:1.6rem;font-weight:700;line-height:1"><?= (int) $count ?></div>
            <div style="font-size:.78rem;color:var(--ff-gray-400);margin-top:.2rem"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></div>
          </div>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
</div>

<div class="row g-4">
  <!-- Recent posts -->
  <div class="col-lg-7">
    <div class="ff-card">
      <div class="ff-card-body" style="padding:1.25rem 1.5rem">
        <h2 style="font-size:.9rem;font-weight:700;margin-bottom:1rem;text-transform:uppercase;letter-spacing:.05em;color:var(--ff-gray-400)">Recent community posts</h2>
        <?php if (empty($recentPosts)): ?>
          <p style="font-size:.85rem;color:var(--ff-gray-400)">No posts yet.</p>
        <?php else: ?>
          <table class="ff-table" style="margin:0">
            <thead>
              <tr><th>Title</th><th>Author</th><th>Date</th></tr>
            </thead>
            <tbody>
              <?php foreach ($recentPosts as $post): ?>
                <tr>
                  <td><?= htmlspecialchars(mb_substr((string) $post['title'], 0, 40), ENT_QUOTES, 'UTF-8') ?></td>
                  <td style="color:var(--ff-gray-500)"><?= htmlspecialchars((string) $post['firstname'] . ' ' . (string) $post['lastname'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td style="color:var(--ff-gray-400);font-size:.78rem"><?= htmlspecialchars(date('d M Y', strtotime((string) $post['created_at'])), ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Recent messages -->
  <div class="col-lg-5">
    <div class="ff-card">
      <div class="ff-card-body" style="padding:1.25rem 1.5rem">
        <h2 style="font-size:.9rem;font-weight:700;margin-bottom:1rem;text-transform:uppercase;letter-spacing:.05em;color:var(--ff-gray-400)">Recent messages</h2>
        <?php if (empty($recentMessages)): ?>
          <p style="font-size:.85rem;color:var(--ff-gray-400)">No messages yet.</p>
        <?php else: ?>
          <div style="display:flex;flex-direction:column;gap:.75rem">
            <?php foreach ($recentMessages as $msg): ?>
              <div style="padding:.75rem;border:1px solid var(--ff-border);border-radius:var(--ff-radius-sm)">
                <div style="font-size:.82rem;font-weight:600"><?= htmlspecialchars((string) $msg['subject'], ENT_QUOTES, 'UTF-8') ?></div>
                <div style="font-size:.75rem;color:var(--ff-gray-400);margin-top:.2rem">
                  <?php
                    $senderName = trim((string) ($msg['firstname'] ?? '') . ' ' . (string) ($msg['lastname'] ?? ''));
                    echo htmlspecialchars($senderName !== '' ? $senderName : 'Guest', ENT_QUOTES, 'UTF-8');
                  ?>
                  &middot; <?= htmlspecialchars(date('d M Y', strtotime((string) $msg['created_at'])), ENT_QUOTES, 'UTF-8') ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
