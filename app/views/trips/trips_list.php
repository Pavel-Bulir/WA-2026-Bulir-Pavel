<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-4xl mx-auto px-6 mt-10">

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
                    <div style="color: <?= $color ?>; border: 1px solid <?= $color ?>; padding: 10px; margin-bottom: 10px; border-radius: 6px;">
                        <strong><?= htmlspecialchars($message) ?></strong>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['messages']); ?>
    <?php endif; ?>

    <h2 class="text-3xl font-semibold text-green-900 mb-6">VÝLETY</h2>

    <?php if (empty($trips)): ?>
        <p class="text-gray-600 italic">V databázi se zatím nenachází žádné výlety.</p>
    <?php else: ?>
        <div class="flex flex-col gap-4">
            <?php foreach ($trips as $trip): ?>
                <?php 
                    $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                    $isOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $trip->created_by;
                ?>
                <div class="flex overflow-hidden rounded-xl border <?= $isOwner ? 'border-green-500' : 'border-gray-300' ?> bg-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    
                    <?php 
                        $images = json_decode($trip->images ?? '[]', true);
                        $firstImage = $images[0] ?? null;
                    ?>
                    <?php if ($firstImage): ?>
                        <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($firstImage) ?>" 
                             alt="<?= htmlspecialchars($trip->name) ?>"
                             class="w-36 min-w-36 object-cover">
                    <?php else: ?>
                        <div class="w-36 min-w-36 bg-green-700 flex items-center justify-center">
                            <svg width="60" height="66" viewBox="0 0 299 329" fill="none">
                                <path d="M138 105L104 156H172L138 105Z" fill="#818180"/>
                                <path d="M110 129L76 180H144L110 129Z" fill="#1a3d16"/>
                                <path d="M138 140L104 180H172L138 140Z" fill="#3d7a34"/>
                                <path d="M166 129L132 180H200L166 129Z" fill="#1a3d16"/>
                                <path d="M122.5 128H153" stroke="white"/>
                                <path d="M138 105L123 128H153.5L138 105Z" fill="#DEDEDE"/>
                            </svg>
                        </div>
                    <?php endif; ?>

                    <div class="p-4 flex flex-col gap-2 flex-1">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-semibold text-green-900">
                                <?= htmlspecialchars($trip->name) ?>
                                <span class="text-xs text-gray-700 font-normal">#<?= $trip->id ?></span>
                                <?php if ($isOwner): ?>
                                    <span class="text-xs px-2 py-1 rounded-full bg-green-800 text-white ml-1">Můj výlet</span>
                                <?php endif; ?>
                            </h3>
                            <span class="text-xs px-3 py-1 rounded-full
                                <?php if ($trip->difficulty_name === 'Lehká') echo 'bg-green-100 text-green-800';
                                elseif ($trip->difficulty_name === 'Střední') echo 'bg-yellow-100 text-yellow-800';
                                else echo 'bg-red-100 text-red-800'; ?>">
                                <?= htmlspecialchars($trip->difficulty_name) ?>
                            </span>
                        </div>

                        <div class="flex gap-4 text-sm text-gray-600">
                            <span><i class="ti ti-map-pin"></i> <?= htmlspecialchars($trip->location) ?></span>
                            <span><i class="ti ti-route"></i> <?= (int)$trip->distance ?> km</span>
                            <span><i class="ti ti-clock"></i> <?= $trip->duration ?> <?= $trip->duration_unit ?></span>
                        </div>

                        <div class="flex gap-2 mt-2">
                            <a href="<?= BASE_URL ?>/index.php?url=trip/show/<?= $trip->id ?>"
                               class="text-sm px-3 py-1 rounded border border-gray-300 hover:bg-gray-50 transition-colors">
                                Detail
                            </a>
                            <?php if ($isOwner || $isAdmin): ?>
                                <a href="<?= BASE_URL ?>/index.php?url=trip/edit/<?= $trip->id ?>"
                                   class="text-sm px-3 py-1 rounded border border-gray-300 hover:bg-gray-50 transition-colors">
                                    Upravit
                                </a>
                                <a href="<?= BASE_URL ?>/index.php?url=trip/delete/<?= $trip->id ?>"
                                   onclick="return confirm('Opravdu chcete smazat tento výlet?')"
                                   class="text-sm px-3 py-1 rounded border border-red-300 text-red-600 hover:bg-red-50 transition-colors">
                                    Smazat
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>