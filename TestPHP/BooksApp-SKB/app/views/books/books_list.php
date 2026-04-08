<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Knihovna</title>

    <style>
        body {
            background: #f5f0e6;
            background-image: url("https://www.transparenttextures.com/patterns/old-wall.png");
        }
    </style>
</head>

<body class="font-serif text-gray-800">

<header class="bg-[#d8c3a5] border-b border-[#b89f85] shadow-lg shadow-[#b89f85]/40">
    <div class="max-w-5xl mx-auto px-6 py-8">
        <h1 class="text-5xl font-bold text-[#4a3f35] drop-shadow-sm tracking-wide">
            Aplikace Knihovna
        </h1>

        <nav class="mt-6">
    <ul class="flex gap-6 text-lg">

        <li>
            <a href="<?= BASE_URL ?>/index.php"
               class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35] 
                      shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                      font-medium tracking-wide">
               Seznam knih
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/index.php?url=book/create"
               class="px-5 py-2 rounded-md bg-[#e8dfd0] border border-[#c8b8a6] text-[#4a3f35] 
                      shadow-sm hover:shadow-md hover:bg-[#f3ede4] transition-all duration-200
                      font-medium tracking-wide">
               Přidat novou knihu
            </a>
        </li>

    </ul>
</nav>
    </div>
</header>

<main class="max-w-5xl mx-auto px-6 mt-12">

    <h2 class="text-4xl font-semibold text-[#4a3f35] mb-8 tracking-wide">
        Dostupné knihy
    </h2>

    <?php if (empty($books)): ?>
        <p class="italic text-gray-600 text-lg">V databázi se zatím nenachází žádné knihy.</p>

    <?php else: ?>
        <div class="overflow-hidden rounded-lg shadow-xl shadow-[#b89f85]/40 border border-[#c8b8a6] bg-[#fcfaf7]">
            <table class="w-full">
                <thead class="bg-[#e8dfd0] text-[#4a3f35]">
                    <tr class="text-left">
                        <th class="p-4 border-b border-[#d6c7b4]">ID</th>
                        <th class="p-4 border-b border-[#d6c7b4]">Název knihy</th>
                        <th class="p-4 border-b border-[#d6c7b4]">Autor</th>
                        <th class="p-4 border-b border-[#d6c7b4]">Rok vydání</th>
                        <th class="p-4 border-b border-[#d6c7b4]">Cena</th>
                        <th class="p-4 border-b border-[#d6c7b4]">Akce</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr class="hover:bg-[#f3ede4] transition-all duration-200 hover:shadow-inner">
                            <td class="p-4 border-b border-[#e5d9c9]"><?= htmlspecialchars($book['id']) ?></td>
                            <td class="p-4 border-b border-[#e5d9c9] font-medium"><?= htmlspecialchars($book['title']) ?></td>
                            <td class="p-4 border-b border-[#e5d9c9]"><?= htmlspecialchars($book['author']) ?></td>
                            <td class="p-4 border-b border-[#e5d9c9]"><?= htmlspecialchars($book['year']) ?></td>
                            <td class="p-4 border-b border-[#e5d9c9]"><?= htmlspecialchars($book['price']) ?> Kč</td>
                            <td class="p-4 border-b border-[#e5d9c9] space-x-3">
                                <a class="text-blue-700 hover:underline" href="<?= BASE_URL ?>/index.php?url=book/show/<?= $book['id'] ?>">Detail</a>
                                <a class="text-green-700 hover:underline" href="<?= BASE_URL ?>/index.php?url=book/edit/<?= $book['id'] ?>">Upravit</a>
                                <a class="text-red-700 hover:underline" href="<?= BASE_URL ?>/index.php?url=book/delete/<?= $book['id'] ?>" onclick="return confirm('Opravdu chcete tuto knihu smazat?')">Smazat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<main class="max-w-5xl mx-auto px-6 mt-12">

    <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
        <div class="space-y-4 mb-6">

            <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                <?php 
                    $color = match($type) {
                        'success' => 'green',
                        'error'   => 'red',
                        'notice'  => 'orange',
                        default   => 'gray'
                    };
                ?>

                <?php foreach ($messages as $message): ?>
                    <div class="border-l-4 p-4 bg-white shadow-md rounded-sm"
                         style="border-color: <?= $color ?>; color: <?= $color ?>;">
                        <strong><?= htmlspecialchars($message) ?></strong>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>

        </div>

        <?php unset($_SESSION['messages']); ?>
    <?php endif; ?>

</main>

</body>
</html>