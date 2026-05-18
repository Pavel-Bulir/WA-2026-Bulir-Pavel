<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <title>Walky</title>
    <style>
    body {
        background-color: #c8d8c8;;
    }
</style>
</head>
<body>
<header style="display:flex; justify-content:space-between; align-items:center; padding:10px 30px; background-color:#f0f7ee; border-bottom:2px solid #2d5a27;">
    <div style="display:flex; align-items:center; gap:10px;">
        <svg width="120" height="80" viewBox="60 90 180 110" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M138 105L104 156H172L138 105Z" fill="#818180" stroke="black"/>
            <path d="M110 129L76 180H144L110 129Z" fill="#235B2A" stroke="black"/>
            <path d="M138 140L104 180H172L138 140Z" fill="#417E48" stroke="black"/>
            <path d="M166 129L132 180H200L166 129Z" fill="#235B2A" stroke="black"/>
            <path d="M122.5 128H153" stroke="black"/>
            <path d="M138 105L123 128H153.5L138 105Z" fill="#DEDEDE" stroke="black"/>
        </svg>
        <div>
            <h1 style="color:#2d5a27; margin:0; font-size:28px; letter-spacing:2px;">WALKY</h1>
            <p style="color:#5a8a52; margin:0; font-size:11px; letter-spacing:4px;">VÝLETY & PŘÍRODA</p>
        </div>
    </div>
    <nav>
    <ul style="list-style:none; display:flex; gap:8px; margin:0; padding:0; align-items:center;">
        <li>
            <a href="<?= BASE_URL ?>/index.php"
               style="color:#2d5a27; text-decoration:none; padding:8px 16px; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px; white-space:nowrap;"
               onmouseover="this.style.backgroundColor='#2d5a27';this.style.color='#f0f7ee'"
               onmouseout="this.style.backgroundColor='transparent';this.style.color='#2d5a27'">
                <i class="ti ti-list"></i> Seznam výletů
            </a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=trip/create"
                   style="color:#f0f7ee; text-decoration:none; padding:8px 16px; background-color:#2d5a27; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px; white-space:nowrap;"
                   onmouseover="this.style.backgroundColor='#1a3d16'"
                   onmouseout="this.style.backgroundColor='#2d5a27'">
                    <i class="ti ti-plus"></i> Přidat nový výlet
                </a>
            </li>

                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
    <li>
        <a href="<?= BASE_URL ?>/index.php?url=auth/users"
           style="color:#2d5a27; text-decoration:none; padding:8px 16px; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px; white-space:nowrap;"
           onmouseover="this.style.backgroundColor='#2d5a27';this.style.color='#f0f7ee'"
           onmouseout="this.style.backgroundColor='transparent';this.style.color='#2d5a27'">
            <i class="ti ti-users"></i> Uživatelé
        </a>
    </li>
<?php endif; ?>

            <li style="font-size:14px; color:#2d5a27;">
            <a href="<?= BASE_URL ?>/index.php?url=auth/profile" style="color:#2d5a27; text-decoration:none;">
                Ahoj, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
            </a>

            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/logout"
                   style="color:#c0392b; text-decoration:none; font-size:14px;">
                    Odhlásit
                </a>
            </li>

        <?php else: ?>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                   style="color:#2d5a27; text-decoration:none; padding:8px 16px; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px;"
                   onmouseover="this.style.backgroundColor='#2d5a27';this.style.color='#f0f7ee'"
                   onmouseout="this.style.backgroundColor='transparent';this.style.color='#2d5a27'">
                    Přihlásit
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=auth/register"
                   style="color:#f0f7ee; text-decoration:none; padding:8px 16px; background-color:#2d5a27; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px;"
                   onmouseover="this.style.backgroundColor='#1a3d16'"
                   onmouseout="this.style.backgroundColor='#2d5a27'">
                    Registrace
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
</header>