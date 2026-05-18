<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-2xl mx-auto px-6 mt-10">
    <h2 class="text-3xl font-semibold text-green-900 mb-6">Upravit výlet <span class="text-lg text-gray-800 font-normal">#<?= $trip->id ?></span></h2>

    <form action="<?= BASE_URL ?>/index.php?url=trip/update/<?= $trip->id ?>" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">

        <div class="flex flex-col gap-1">
            <label for="name" class="text-green-900 font-medium">Název výletu *</label>
            <input type="text" id="name" name="name" required
                value="<?= htmlspecialchars($trip->name) ?>"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
        </div>

        <div class="flex flex-col gap-1">
            <label for="distance" class="text-green-900 font-medium">Délka trasy (km) *</label>
            <input type="number" id="distance" name="distance" required
                value="<?= (int)$trip->distance ?>"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-green-900 font-medium">Doba trvání *</label>
            <div class="flex gap-2">
                <input type="number" id="duration" name="duration" required min="1"
                    value="<?= $trip->duration ?>"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white w-24">
                <select id="duration_unit" name="duration_unit"
                    class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
                    <option value="hod" <?= $trip->duration_unit === 'hod' ? 'selected' : '' ?>>Hodiny</option>
                    <option value="dny" <?= $trip->duration_unit === 'dny' ? 'selected' : '' ?>>Dny</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label for="difficulty" class="text-green-900 font-medium">Obtížnost *</label>
            <select id="difficulty" name="difficulty_id" required
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
                <option value="">-- Vyberte --</option>
                <option value="1" <?= $trip->difficulty_id == 1 ? 'selected' : '' ?>>Lehká</option>
                <option value="2" <?= $trip->difficulty_id == 2 ? 'selected' : '' ?>>Střední</option>
                <option value="3" <?= $trip->difficulty_id == 3 ? 'selected' : '' ?>>Těžká</option>
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label for="location" class="text-green-900 font-medium">Místo/region *</label>
            <input type="text" id="location" name="location" required
                value="<?= htmlspecialchars($trip->location) ?>"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
        </div>

        <div class="flex flex-col gap-1">
            <label for="route_url" class="text-green-900 font-medium">Odkaz na trasu *</label>
            <input type="url" id="route_url" name="route_url" required
                value="<?= $trip->route_url ?>"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white">
        </div>

        <div class="flex flex-col gap-1">
            <label for="attractions" class="text-green-900 font-medium">Zajímavosti po cestě</label>
            <textarea id="attractions" name="attractions" rows="4"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white"><?= htmlspecialchars($trip->attractions ?? '') ?></textarea>
        </div>

        <?php $suitableFor = json_decode($trip->suitable_for ?? '[]', true); ?>
        <div class="flex flex-col gap-1">
            <label class="text-green-900 font-medium">Vhodné pro</label>
            <div class="flex flex-col gap-2">
                <label class="flex items-center gap-2 text-green-900">
                    <input type="checkbox" name="suitable_for[]" value="pesi" class="accent-green-700"
                        <?= in_array('pesi', $suitableFor) ? 'checked' : '' ?>>
                    Pěší
                </label>
                <label class="flex items-center gap-2 text-green-900">
                    <input type="checkbox" name="suitable_for[]" value="cyklistika" class="accent-green-700"
                        <?= in_array('cyklistika', $suitableFor) ? 'checked' : '' ?>>
                    Cyklistika
                </label>
                <label class="flex items-center gap-2 text-green-900">
                    <input type="checkbox" name="suitable_for[]" value="rodiny" class="accent-green-700"
                        <?= in_array('rodiny', $suitableFor) ? 'checked' : '' ?>>
                    Rodiny s dětmi
                </label>
                <label class="flex items-center gap-2 text-green-900">
                    <input type="checkbox" name="suitable_for[]" value="inline" class="accent-green-700"
                        <?= in_array('inline', $suitableFor) ? 'checked' : '' ?>>
                    Inline brusle
                </label>
            </div>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-green-900 font-medium">Omezení</label>
            <label class="flex items-center gap-2 text-green-900">
                <input type="checkbox" name="no_dogs" value="1" class="accent-green-700"
                    <?= $trip->no_dogs ? 'checked' : '' ?>>
                Zákaz vstupu se psem
            </label>
        </div>

        <div class="flex flex-col gap-1">
            <label for="notes" class="text-green-900 font-medium">Poznámky</label>
            <textarea id="notes" name="notes" rows="3"
                class="border border-gray-900 rounded px-3 py-2 focus:outline-none focus:border-green-600 bg-white"><?= htmlspecialchars($trip->notes ?? '') ?></textarea>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-green-900 font-medium">Fotografie</label>
            <?php if (!empty($trip->images)): ?>
    <div class="flex flex-wrap gap-3 mb-3">
        <?php foreach (json_decode($trip->images) as $img): ?>
            <img src="<?= BASE_URL ?>/uploads/<?= $img ?>" 
                 class="w-24 h-24 object-cover rounded border border-gray-300">
        <?php endforeach; ?>
    </div>
<?php endif; ?>
            <label for="images"
                   class="flex flex-col items-center justify-center w-full h-24 border-2 border-grey-800 border-dashed rounded-lg cursor-pointer bg-white hover:bg-green-50 transition-colors">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <span id="file-title" class="text-sm text-green-900 font-semibold">Klikni pro výběr souborů</span>
                    <span id="file-info" class="text-xs text-green-900 mt-1 text-center px-4">Žádné soubory nebyly vybrány</span>
                </div>
                <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
            </label>
        </div>

        <div>
    <button type="submit"
            style="background-color:#166534; color:white; padding:8px 24px; border-radius:6px; border:none; cursor:pointer; font-size:14px;"
            onmouseover="this.style.backgroundColor='#1a3d16'"
            onmouseout="this.style.backgroundColor='#166534'">
        Uložit výlet
    </button>
        </div>

    </form>
</main>

<script>
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');

    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;

        if (files.length === 0) {
            fileTitle.textContent = 'Klikni pro výběr souborů';
            fileTitle.className = 'text-sm text-green-900 font-semibold';
            fileInfo.textContent = 'Žádné soubory nebyly vybrány';
            fileInfo.className = 'text-xs text-green-900 mt-1 text-center px-4';
        } 
        else if (files.length === 1) {
            fileTitle.textContent = '1 soubor vybrán';
            fileTitle.className = 'text-sm text-green-900 font-semibold';
            fileInfo.textContent = files[0].name;
            fileInfo.className = 'text-xs text-green-900 mt-1 text-center px-4';
        } 
        else {
            fileTitle.textContent = files.length + ' souborů vybráno';
            fileTitle.className = 'text-sm text-green-900 font-semibold';
            fileInfo.textContent = Array.from(files).map(f => f.name).join(', ');
            fileInfo.className = 'text-xs text-green-900 mt-1 text-center px-4';
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>