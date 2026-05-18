<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-2xl mx-auto px-6 mt-10">

    <a href="<?= BASE_URL ?>/index.php" 
       class="text-sm text-green-800 hover:underline">
        ← Zpět na seznam výletů
    </a>

    <div class="mt-6 bg-white rounded-xl border border-gray-300 shadow-sm overflow-hidden">

        <?php 
            $images = json_decode($trip->images ?? '[]', true);
            $firstImage = $images[0] ?? null;
        ?>
        <?php if ($firstImage): ?>
            <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($firstImage) ?>" 
                 alt="<?= htmlspecialchars($trip->name) ?>"
                 class="w-full h-64 object-cover">
        <?php else: ?>
            <div class="w-full h-48 bg-green-700 flex items-center justify-center">
                <svg width="80" height="88" viewBox="0 0 299 329" fill="none">
                    <path d="M138 105L104 156H172L138 105Z" fill="#818180"/>
                    <path d="M110 129L76 180H144L110 129Z" fill="#1a3d16"/>
                    <path d="M138 140L104 180H172L138 140Z" fill="#3d7a34"/>
                    <path d="M166 129L132 180H200L166 129Z" fill="#1a3d16"/>
                    <path d="M122.5 128H153" stroke="white"/>
                    <path d="M138 105L123 128H153.5L138 105Z" fill="#DEDEDE"/>
                </svg>
            </div>
        <?php endif; ?>

        <div class="p-6 flex flex-col gap-4">

            <h2 class="text-2xl font-semibold text-green-900"><?= htmlspecialchars($trip->name) ?> <span class="text-sm text-gray-400 font-normal">#<?= $trip->id ?></span></h2>

            <div class="flex flex-col gap-2 text-sm text-gray-700">
                <p><span class="font-medium text-green-900">Místo:</span> <?= htmlspecialchars($trip->location) ?></p>
                <p><span class="font-medium text-green-900">Délka trasy:</span> <?= (int)$trip->distance ?> km</p>
                <p><span class="font-medium text-green-900">Doba trvání:</span> <?= $trip->duration ?> <?= $trip->duration_unit ?></p>
                <p><span class="font-medium text-green-900">Obtížnost:</span> <?= htmlspecialchars($trip->difficulty_name) ?></p>
            </div>

            <div>
                <p class="text-sm font-medium text-green-900 mb-1">Odkaz na trasu</p>
                <a href="<?= $trip->route_url ?>" target="_blank" 
                   class="text-sm text-blue-600 hover:underline">
                    <?= $trip->route_url ?>
                </a>
            </div>

            <?php if ($trip->attractions): ?>
            <div>
                <p class="text-sm font-medium text-green-900 mb-1">Zajímavosti po cestě</p>
                <p class="text-sm text-gray-700"><?= htmlspecialchars($trip->attractions) ?></p>
            </div>
            <?php endif; ?>

            <?php 
                $suitableFor = json_decode($trip->suitable_for ?? '[]', true);
                $labels = ['pesi' => 'Pěší', 'cyklistika' => 'Cyklistika', 'rodiny' => 'Rodiny s dětmi', 'inline' => 'Inline brusle'];
            ?>
            <?php if (!empty($suitableFor)): ?>
            <div>
                <p class="text-sm font-medium text-green-900 mb-1">Vhodné pro</p>
                <div class="flex gap-2 flex-wrap">
                    <?php foreach ($suitableFor as $item): ?>
                        <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-800">
                            <?= $labels[$item] ?? $item ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($trip->no_dogs): ?>
            <p class="text-sm text-red-600"><i class="ti ti-alert-circle"></i> Zákaz vstupu se psem</p>
            <?php endif; ?>

            <?php if ($trip->notes): ?>
            <div>
                <p class="text-sm font-medium text-green-900 mb-1">Poznámky</p>
                <p class="text-sm text-gray-700"><?= htmlspecialchars($trip->notes) ?></p>
            </div>
            <?php endif; ?>

            <!-- Fotogalerie -->
            <?php if (!empty($images)): ?>
            <div>
                <p class="text-sm font-medium text-green-900 mb-2">Fotografie</p>
                <div class="grid grid-cols-3 gap-2">
                    <?php foreach ($images as $image): ?>
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($image) ?>"
                             class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="flex gap-2 mt-2 border-t border-gray-200 pt-4">
                <a href="<?= BASE_URL ?>/index.php?url=trip/edit/<?= $trip->id ?>"
                   class="text-sm px-3 py-1 rounded border border-gray-300 hover:bg-gray-50 transition-colors">
                    Upravit
                </a>
                <a href="<?= BASE_URL ?>/index.php?url=trip/delete/<?= $trip->id ?>"
                   onclick="return confirm('Opravdu chcete smazat tento výlet?')"
                   class="text-sm px-3 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 transition-colors">
                    Smazat
                </a>
            </div>

        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>