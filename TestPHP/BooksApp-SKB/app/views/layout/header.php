<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Přidat novou knihu</title>

    <style>
        body {
            background: #f5f0e6;
            background-image: url("https://www.transparenttextures.com/patterns/old-wall.png");
        }
    </style>
</head>

<body class="text-white">

    <header class="bg-[#d8c3a5] border-b border-[#b89f85] shadow-lg shadow-[#b89f85]/40">
    <div class="max-w-5xl mx-auto px-6 py-8">

        <h1 class="text-5xl font-bold text-[#4a3f35] drop-shadow-sm tracking-wide">
            Aplikace Knihovna
        </h1>

        <nav class="mt-6">
            <ul class="flex gap-6 text-lg">

                <!-- Seznam knih -->
                <li>
                    <a href="<?= BASE_URL ?>/index.php"
                       class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35]
                              shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                              font-medium tracking-wide">
                        Seznam knih
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <!-- Přidat knihu -->
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=book/create"
                           class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35]
                                  shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                                  font-medium tracking-wide">
                            Přidat novou knihu
                        </a>
                    </li>

                    <!-- Jméno uživatele -->
                    <li class="px-3 py-2 text-[#4a3f35] font-medium italic">
                        Ahoj,
                        <span class="font-semibold">
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </span>
                    </li>

                    <!-- Odhlášení -->
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/logout"
                           class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35]
                                  shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                                  font-medium tracking-wide">
                            Odhlásit
                        </a>
                    </li>

                <?php else: ?>

                    <!-- Přihlášení -->
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/login"
                           class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35]
                                  shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                                  font-medium tracking-wide">
                            Přihlásit
                        </a>
                    </li>

                    <!-- Registrace -->
                    <li>
                        <a href="<?= BASE_URL ?>/index.php?url=auth/register"
                           class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35]
                                  shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                                  font-medium tracking-wide">
                            Registrace
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </nav>

    </div>
</header>

    <!-- Zbytek stránky -->