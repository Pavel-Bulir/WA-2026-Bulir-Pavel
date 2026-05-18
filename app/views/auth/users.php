<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-4xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Správa uživatelů</h2>

    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
        <div class="mb-6">
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php 
                    if ($type === 'success') $color = 'green';
                    elseif ($type === 'error') $color = 'red';
                    else $color = 'orange';
                ?>
                <?php foreach ($messages as $message): ?>
                    <div style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px; border-radius: 6px;">
                        <strong><?= htmlspecialchars($message) ?></strong>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['messages']); ?>
    <?php endif; ?>

    <div class="flex flex-col gap-4">
        <?php foreach ($users as $user): ?>
            <div class="flex justify-between items-center bg-white rounded-xl border border-gray-300 shadow-sm p-4">
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-green-900"><?= htmlspecialchars($user['username']) ?></span>
                        <?php if ($user['is_admin']): ?>
                            <span style="font-size:11px; background:#2d5a27; color:white; padding:2px 8px; border-radius:10px;">Admin</span>
                        <?php endif; ?>
                        <?php if ($user['id'] == $_SESSION['user_id']): ?>
                            <span style="font-size:11px; background:#3b82f6; color:white; padding:2px 8px; border-radius:10px;">Já</span>
                        <?php endif; ?>
                    </div>
                    <span class="text-sm text-gray-600"><?= htmlspecialchars($user['email']) ?></span>
                    <span class="text-xs text-gray-400">Registrován: <?= $user['created_at'] ?></span>
                </div>
                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                    <a href="<?= BASE_URL ?>/index.php?url=auth/deleteUser/<?= $user['id'] ?>"
                       onclick="return confirm('Opravdu chcete smazat uživatele <?= htmlspecialchars($user['username']) ?>?')"
                       class="text-sm px-3 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 transition-colors">
                        Smazat
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>