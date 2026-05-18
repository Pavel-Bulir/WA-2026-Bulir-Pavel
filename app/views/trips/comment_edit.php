<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-2xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Upravit komentář</h2>

    <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
        <form action="<?= BASE_URL ?>/index.php?url=trip/updateComment/<?= $comment['id'] ?>" method="POST" class="flex flex-col gap-4">

            <div class="flex flex-col gap-1">
                <label for="content" class="text-green-900 font-medium">Komentář</label>
                <textarea id="content" name="content" rows="4" required
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white"><?= htmlspecialchars($comment['content']) ?></textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="bg-green-800 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors">
                    Uložit změny
                </button>
                <a href="<?= BASE_URL ?>/index.php?url=trip/show/<?= $comment['trip_id'] ?>"
                   class="px-6 py-2 rounded border border-gray-300 hover:bg-gray-50 transition-colors">
                    Zrušit
                </a>
            </div>

        </form>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>