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
        <ul style="list-style:none; display:flex; gap:12px; margin:0; padding:0; align-items:center;">
            <li>
                <a href="<?= BASE_URL ?>/index.php"
                   style="color:#2d5a27; text-decoration:none; padding:8px 16px; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px;"
                   onmouseover="this.style.backgroundColor='#2d5a27';this.style.color='#f0f7ee'"
                   onmouseout="this.style.backgroundColor='transparent';this.style.color='#2d5a27'">
                    <i class="ti ti-list"></i> Seznam výletů
                </a>
            </li>
            <li>
                <a href="<?= BASE_URL ?>/index.php?url=trip/create"
                   style="color:#f0f7ee; text-decoration:none; padding:8px 16px; background-color:#2d5a27; border:1.5px solid #2d5a27; border-radius:6px; font-size:14px;"
                   onmouseover="this.style.backgroundColor='#1a3d16'"
                   onmouseout="this.style.backgroundColor='#2d5a27'">
                    <i class="ti ti-plus"></i> Přidat nový výlet
                </a>
            </li>
        </ul>
    </nav>
</header>