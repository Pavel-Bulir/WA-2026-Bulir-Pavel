<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-2xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Můj profil</h2>

    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
        <div class="mb-6">
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php 
                    if ($type === 'success') $color = 'green';
                    elseif ($type === 'error') $color = 'red';
                    else $color = 'black';
                ?>
                <?php foreach ($messages as $message): ?>
                    <div class="notification" style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px; border-radius: 6px; display:flex; justify-content:space-between; align-items:center;">
                        <strong><?= htmlspecialchars($message) ?></strong>
                        <span onclick="this.parentElement.remove()" style="cursor:pointer; font-size:18px; margin-left:10px;">&times;</span>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['messages']); ?>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6 flex flex-col gap-6">

        <!-- Nepředitelné údaje -->
        <div class="flex flex-col gap-2 border-b border-gray-200 pb-4">
            <h3 class="text-green-800 font-semibold">Přihlašovací údaje</h3>
            <p class="text-sm text-gray-700"><span class="font-medium text-green-900">Uživatelské jméno:</span> <?= htmlspecialchars($user['username']) ?></p>
            <p class="text-sm text-gray-700"><span class="font-medium text-green-900">E-mail:</span> <?= htmlspecialchars($user['email']) ?></p>
            <p class="text-sm text-gray-700"><span class="font-medium text-green-900">Účet vytvořen:</span> <?= $user['created_at'] ?></p>
        </div>

        <!-- Editovatelné údaje -->
        <form action="<?= BASE_URL ?>/index.php?url=auth/updateProfile" method="POST" class="flex flex-col gap-4">
            <h3 class="text-green-800 font-semibold">Osobní údaje</h3>

            <div class="flex flex-col gap-1">
                <label for="first_name" class="text-green-900 font-medium">Křestní jméno</label>
                <input type="text" id="first_name" name="first_name"
                    value="<?= htmlspecialchars($user['first_name'] ?? '') ?>"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="last_name" class="text-green-900 font-medium">Příjmení</label>
                <input type="text" id="last_name" name="last_name"
                    value="<?= htmlspecialchars($user['last_name'] ?? '') ?>"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="nickname" class="text-green-900 font-medium">Přezdívka</label>
                <input type="text" id="nickname" name="nickname"
                    value="<?= htmlspecialchars($user['nickname'] ?? '') ?>"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <button type="submit"
                    class="bg-green-800 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors w-fit">
                Uložit změny
            </button>
        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>