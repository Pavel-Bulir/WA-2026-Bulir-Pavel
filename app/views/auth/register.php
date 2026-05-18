<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-2xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Nová registrace</h2>

    <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
        <form action="<?= BASE_URL ?>/index.php?url=auth/storeUser" method="post" class="flex flex-col gap-4">

            <h3 class="text-green-800 font-semibold border-b border-gray-200 pb-2">Přihlašovací údaje</h3>

            <div class="flex flex-col gap-1">
                <label for="username" class="text-green-900 font-medium">Uživatelské jméno *</label>
                <input type="text" id="username" name="username" required
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="email" class="text-green-900 font-medium">E-mail *</label>
                <input type="email" id="email" name="email" required
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="text-green-900 font-medium">Heslo *</label>
                <input type="password" id="password" name="password" required
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="password_confirm" class="text-green-900 font-medium">Potvrzení hesla *</label>
                <input type="password" id="password_confirm" name="password_confirm" required
                  class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
                <span id="confirm-error" style="display:none; color:red; font-size:13px;">Hesla se neshodují</span>
            </div>

            <h3 class="text-green-800 font-semibold border-b border-gray-200 pb-2 mt-2">Osobní údaje (volitelné)</h3>

            <div class="flex flex-col gap-1">
                <label for="first_name" class="text-green-900 font-medium">Křestní jméno</label>
                <input type="text" id="first_name" name="first_name"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="last_name" class="text-green-900 font-medium">Příjmení</label>
                <input type="text" id="last_name" name="last_name"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <div class="flex flex-col gap-1">
                <label for="nickname" class="text-green-900 font-medium">Přezdívka</label>
                <input type="text" id="nickname" name="nickname" placeholder="Jak vám máme říkat?"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
            </div>

            <button type="submit"
                    class="bg-green-800 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors w-fit mt-2">
                Vytvořit účet
            </button>

            <p class="text-sm text-gray-600">
                Už máte účet? <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-green-700 hover:underline">Přihlaste se zde</a>.
            </p>

        </form>
    </div>
</main>

<script> //zvýrazní pole, protože se špatně zadalo potvrzení hesla
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirm').value;
        
        if (password !== confirm) {
            e.preventDefault(); // zastaví odeslání formuláře
            document.getElementById('password_confirm').style.borderColor = 'red';
            document.getElementById('confirm-error').style.display = 'block';
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>