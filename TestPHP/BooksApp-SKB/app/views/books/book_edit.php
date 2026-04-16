<?php require_once '../app/views/layout/header.php'; ?>

<body class="font-serif text-gray-800">

<div class="max-w-5xl mx-auto px-6 py-10">

    <!-- Zpět -->
    <p class="mb-6">
        <a href="<?= BASE_URL ?>/index.php"
           class="inline-block px-4 py-2 bg-[#e8dfd0] border border-[#c8b8a6] rounded-md
                  text-[#4a3f35] shadow-sm hover:shadow-md hover:bg-[#f3ede4]
                  transition-all duration-200 font-medium">
            ← Zpět na seznam knih
        </a>
    </p>

    <!-- Nadpis -->
    <div class="mb-10">
        <h2 class="text-4xl font-bold text-[#4a3f35] mb-3">
            Upravit knihu (ID: <?= htmlspecialchars($book['id']) ?>)
        </h2>

        <p class="text-lg text-gray-700">
            Upravujete data pro knihu:
            <strong class="text-[#4a3f35]"><?= htmlspecialchars($book['title']) ?></strong>
        </p>

        <p class="text-gray-600 mt-1">
            Změňte požadované údaje a uložte formulář.
        </p>
    </div>

    <!-- Formulář -->
    <div class="bg-[#fcfaf7] border border-[#c8b8a6] shadow-xl shadow-[#b89f85]/40 rounded-lg p-8">

        <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= $book['id'] ?>" method="post">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- LEVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Název knihy *</label>
                        <input type="text" name="title" required
                               value="<?= htmlspecialchars($book['title']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Autor *</label>
                        <input type="text" name="author" required
                               value="<?= htmlspecialchars($book['author']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">ISBN</label>
                        <input type="number" name="isbn"
                               value="<?= htmlspecialchars($book['isbn']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Rok vydání *</label>
                        <input type="number" name="year" required
                               value="<?= htmlspecialchars($book['year']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Cena</label>
                        <input type="number" name="price" step="0.5"
                               value="<?= htmlspecialchars($book['price']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                </div>

                <!-- PRAVÝ SLOUPEC -->
                <div class="space-y-6">



                    <div>
    <label for="category" class="block font-medium text-[#4a3f35] mb-1">Kategorie *</label>

    <select id="category" name="category" required
            class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                   focus:ring-2 focus:ring-[#b89f85]">

        <option value="">-- Vyberte kategorii --</option>

        <?php foreach ($categories as $cat): ?>
            <?php 
                $isSelected = ($book['category'] == $cat['id']) ? 'selected' : ''; 
            ?>
            <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $isSelected ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>

    </select>
</div>


                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Podkategorie</label>
                        <input type="text" name="subcategory"
                               value="<?= htmlspecialchars($book['subcategory']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Odkaz</label>
                        <input type="text" name="link"
                               value="<?= htmlspecialchars($book['link']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Popis knihy</label>
                        <textarea name="description" rows="6"
                                  class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                                  focus:ring-2 focus:ring-[#b89f85]"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                </div>

            </div>

            <!-- Tlačítko -->
            <div class="pt-8">
                <button type="submit"
                        class="px-6 py-3 bg-[#d6bfa5] border border-[#b89f85] rounded-md
                        text-[#4a3f35] font-semibold shadow-sm hover:shadow-md
                        hover:bg-[#e2cfba] transition-all duration-200">
                    Uložit změny
                </button>
            </div>

        </form>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>
