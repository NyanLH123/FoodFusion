<?php $base = rtrim((string) ($appConfig['base_url'] ?? ''), '/'); ?>
<table class="ff-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Locked</th>
      <th>ID</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td style="color:var(--ff-gray-400)"><?= (int) $u['userId'] ?></td>
        <td><?= htmlspecialchars((string) $u['firstname'] . ' ' . (string) $u['lastname'], ENT_QUOTES, 'UTF-8') ?></td>
        <td style="color:var(--ff-gray-500)"><?= htmlspecialchars((string) $u['email'], ENT_QUOTES, 'UTF-8') ?></td>
        <td>
          <span class="ff-tag <?= (int) $u['role'] === 1 ? 'ff-tag-green' : '' ?>">
            <?= (int) $u['role'] === 1 ? 'admin' : 'user' ?>
          </span>
        </td>
        <td>
          <?php if (!empty($u['locked_until']) && strtotime((string) $u['locked_until']) > time()): ?>
            <span class="ff-tag ff-tag-red">Locked</span>
          <?php else: ?>
            <span style="color:var(--ff-gray-300)">—</span>
          <?php endif; ?>
        </td>
        <td style="color:var(--ff-gray-400);font-size:.78rem">
          <?= htmlspecialchars((string) $u['userId'], ENT_QUOTES, 'UTF-8') ?>
        </td>
        <td>
          <div class="d-flex gap-1 flex-wrap">
            <!-- Toggle role -->
            <form method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/users" style="display:inline">
              <input type="hidden" name="action" value="toggle_role">
              <input type="hidden" name="userId" value="<?= (int) $u['userId'] ?>">
              <button class="btn-ff-outline btn-ff-sm" type="submit" style="border-width:1px"
                title="<?= (int) $u['role'] === 1 ? 'Demote to user' : 'Promote to admin' ?>">
                <?= (int) $u['role'] === 1 ? 'Demote' : 'Promote' ?>
              </button>
            </form>
            <!-- Unlock -->
            <?php if (!empty($u['locked_until']) && strtotime((string) $u['locked_until']) > time()): ?>
              <form method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/users" style="display:inline">
                <input type="hidden" name="action" value="unlock">
                <input type="hidden" name="userId" value="<?= (int) $u['userId'] ?>">
                <button class="btn-ff-outline btn-ff-sm" type="submit" style="border-width:1px">Unlock</button>
              </form>
            <?php endif; ?>
            <!-- Delete -->
            <form method="post" action="<?= htmlspecialchars($base, ENT_QUOTES, 'UTF-8') ?>/admin/users" style="display:inline"
                  onsubmit="return confirm('Delete this user?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="userId" value="<?= (int) $u['userId'] ?>">
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
