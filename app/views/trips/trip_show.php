<?php require_once '../app/views/layout/header.php'; ?>

<main class="max-w-6xl mx-auto px-6 mt-10">

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

    <a href="<?= BASE_URL ?>/index.php" class="text-sm text-green-800 hover:underline">
        ← Zpět na seznam výletů
    </a>

    <div class="mt-6 grid grid-cols-5 gap-6">

        <!-- LEVÝ SLOUPEC – detail výletu -->
        <div class="col-span-3 flex flex-col gap-4">
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm overflow-hidden">

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
                        <p><span class="font-medium text-green-900">Vytvořil:</span> <?= htmlspecialchars($trip->author_name) ?></p>
                        <p><span class="font-medium text-green-900">Místo:</span> <?= htmlspecialchars($trip->location) ?></p>
                        <p><span class="font-medium text-green-900">Délka trasy:</span> <?= (int)$trip->distance ?> km</p>
                        <p><span class="font-medium text-green-900">Doba trvání:</span> <?= $trip->duration ?> <?= $trip->duration_unit ?></p>
                        <p><span class="font-medium text-green-900">Obtížnost:</span> <?= htmlspecialchars($trip->difficulty_name) ?></p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-green-900 mb-1">Odkaz na trasu</p>
                        <a href="<?= $trip->route_url ?>" target="_blank" class="text-sm text-blue-600 hover:underline">
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

                    <?php if (!empty($images)): ?>
                    <div>
                        <p class="text-sm font-medium text-green-900 mb-2">Fotografie</p>
                        <div class="grid grid-cols-3 gap-2">
                            <?php foreach ($images as $image): ?>
                                <a href="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($image) ?>" target="_blank">
                                    <img src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($image) ?>"
                                         class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="flex gap-2 mt-2 border-t border-gray-200 pt-4">
                        <?php 
                            $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                            if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $trip->created_by || $isAdmin)): ?>
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
        </div>

        <!-- PRAVÝ SLOUPEC – hodnocení + komentáře -->
        <div class="col-span-2 flex flex-col gap-4">

            <!-- Hodnocení -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-4">Hodnocení</h3>

                <div class="flex items-center gap-3 mb-4">
                    <?php 
                        $avg = $ratingData['average'] ?? 0;
                        $count = $ratingData['count'] ?? 0;
                    ?>
                    <div style="display:flex; gap:4px;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span style="font-size:24px; color:<?= $i <= round($avg) ? '#f59e0b' : '#d1d5db' ?>;">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="text-sm text-gray-600"><?= $avg ?> / 5 (<?= $count ?> hodnocení)</span>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="<?= BASE_URL ?>/index.php?url=trip/rate/<?= $trip->id ?>" method="POST">
                        <p class="text-sm text-green-900 font-medium mb-2">
                            <?= $userRating ? 'Vaše hodnocení: ' . $userRating['rating'] . ' ★ (můžete změnit)' : 'Ohodnoťte tento výlet:' ?>
                        </p>
                        <div class="flex flex-wrap gap-2 items-center">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <label class="flex items-center gap-1 cursor-pointer">
                                    <input type="radio" name="rating" value="<?= $i ?>" 
                                           <?= ($userRating && $userRating['rating'] == $i) ? 'checked' : '' ?>
                                           class="accent-green-700">
                                    <span style="font-size:20px; color:#f59e0b;">★</span>
                                    <?= $i ?>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <button type="submit"
                                style="margin-top:8px; background-color:#166534; color:white; padding:6px 16px; border-radius:6px; border:none; cursor:pointer; font-size:13px;">
                            Uložit
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-sm text-gray-500">
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-green-700 hover:underline">Přihlaste se</a> pro hodnocení.
                    </p>
                <?php endif; ?>
            </div>

            <!-- Komentáře -->
            <div class="bg-white rounded-xl border border-gray-300 shadow-sm p-6">
                <h3 class="text-lg font-semibold text-green-900 mb-4">Komentáře (<?= count($comments) ?>)</h3>

                <div class="flex flex-col gap-4 mb-6">
                    <?php if (empty($comments)): ?>
                        <p class="text-sm text-gray-500 italic">Zatím žádné komentáře.</p>
                    <?php else: ?>
                        <?php foreach ($comments as $comment): ?>
                            <?php 
                                $name = !empty($comment['nickname']) ? $comment['nickname'] : $comment['username'];
                                $initials = strtoupper(substr($name, 0, 2));
                            ?>
                            <div style="display:flex; gap:12px; align-items:flex-start;">
                                <div style="width:36px; height:36px; min-width:36px; border-radius:50%; background:#eaf3de; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:500; color:#3B6D11;">
                                    <?= $initials ?>
                                </div>
                                <div style="flex:1;">
                                    <div style="display:flex; justify-content:space-between; align-items:center;">
                                        <span style="font-size:13px; font-weight:500;"><?= htmlspecialchars($name) ?></span>
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <span style="font-size:12px; color:#9ca3af;"><?= $comment['created_at'] ?></span>
                                            <?php 
                                                $isCommentAuthor = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id'];
                                                $isTripOwner = isset($_SESSION['user_id']) && $_SESSION['user_id'] == $trip->created_by;
                                                $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
                                            ?>
                                            <?php if ($isCommentAuthor): ?>
                                                <a href="<?= BASE_URL ?>/index.php?url=trip/editComment/<?= $comment['id'] ?>"
                                                   style="font-size:12px; color:#2d5a27;">Upravit</a>
                                            <?php endif; ?>
                                            <?php if ($isCommentAuthor || $isTripOwner || $isAdmin): ?>
                                                <a href="<?= BASE_URL ?>/index.php?url=trip/deleteComment/<?= $comment['id'] ?>"
                                                   onclick="return confirm('Opravdu chcete smazat tento komentář?')"
                                                   style="font-size:12px; color:#ef4444;">Smazat</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p style="font-size:14px; color:#4b5563; margin:4px 0 0;"><?= htmlspecialchars($comment['content']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php 
                        $myName = $_SESSION['user_name'];
                        $myInitials = strtoupper(substr($myName, 0, 2));
                    ?>
                    <div style="border-top:1px solid #e5e7eb; padding-top:1rem; display:flex; gap:12px; align-items:flex-start;">
                        <div style="width:36px; height:36px; min-width:36px; border-radius:50%; background:#eaf3de; display:flex; align-items:center; justify-content:center; font-size:13px; font-weight:500; color:#3B6D11;">
                            <?= $myInitials ?>
                        </div>
                        <form action="<?= BASE_URL ?>/index.php?url=trip/addComment/<?= $trip->id ?>" method="POST" style="flex:1;">
                            <textarea name="content" rows="3" required placeholder="Přidat komentář..."
                                style="width:100%; border:1px solid #d1d5db; border-radius:6px; padding:8px 12px; font-size:14px; resize:none; box-sizing:border-box;"></textarea>
                            <button type="submit"
                                    style="margin-top:8px; font-size:13px; padding:6px 16px; border-radius:6px; background:#2d5a27; color:white; border:none; cursor:pointer;">
                                Odeslat
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500 border-t border-gray-200 pt-4">
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-green-700 hover:underline">Přihlaste se</a> pro přidání komentáře.
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>

</main>

<?php require_once '../app/views/layout/footer.php'; ?>