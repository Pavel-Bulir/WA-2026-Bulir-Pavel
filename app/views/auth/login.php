<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-md mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Přihlášení</h2>

    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
        <div class="mb-6">
            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php 
                    if ($type === 'success') $color = 'green';
                    elseif ($type === 'error') $color = 'red';
                    elseif ($type === 'notice') $color = 'orange';
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

    <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
        <form action="<?= BASE_URL ?>/index.php?url=auth/authenticate" method="post" class="flex flex-col gap-4">

            <div class="flex flex-col gap-1">
                <label for="email" class="text-green-900 font-medium">E-mail</label>
                <input type="email" id="email" name="email" required autofocus
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="text-green-900 font-medium">Heslo</label>
                <div style="position:relative;">
                    <input type="password" id="password" name="password" required
                        class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white"
                        style="width:100%; box-sizing:border-box;">
                    <span onclick="
                        const i = document.getElementById('password');
                        i.type = i.type === 'password' ? 'text' : 'password';
                        this.classList.toggle('ti-eye');
                        this.classList.toggle('ti-eye-off');
                    " class="ti ti-eye" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; color:#6b7280;"></span>
                </div>
            </div>

            <button type="submit"
                    class="bg-green-800 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors w-fit">
                Přihlásit se
            </button>

            <p class="text-sm text-gray-600 border-t border-gray-200 pt-4">
                Nemáte ještě účet? <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="text-green-700 hover:underline">Zaregistrujte se</a>.
            </p>

        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>