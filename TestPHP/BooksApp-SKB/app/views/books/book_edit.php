<?php require_once '../app/views/layout/header.php'; ?>

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

        <form action="<?= BASE_URL ?>/index.php?url=book/update/<?= htmlspecialchars($book['id']) ?>"
              method="post" enctype="multipart/form-data">

            <!-- GRID 2 SLOUPCE -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- LEVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">ID v databázi</label>
                        <input type="text" value="<?= htmlspecialchars($book['id']) ?>" readonly
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-gray-100 text-gray-700">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">
                            Název knihy <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="title" required
                               value="<?= htmlspecialchars($book['title']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">
                            Autor <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="author" required
                               value="<?= htmlspecialchars($book['author']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">ISBN</label>
                        <input type="text" name="isbn"
                               value="<?= htmlspecialchars($book['isbn']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">
                            Rok vydání <span class="text-red-600">*</span>
                        </label>
                        <input type="number" name="year" required
                               value="<?= htmlspecialchars($book['year']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Cena knihy</label>
                        <input type="number" step="0.5" name="price"
                               value="<?= htmlspecialchars($book['price']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                </div>

                <!-- PRAVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Kategorie</label>
                        <input type="text" name="category"
                               value="<?= htmlspecialchars($book['category']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Podkategorie</label>
                        <input type="text" name="subcategory"
                               value="<?= htmlspecialchars($book['subcategory']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Odkaz</label>
                        <input type="text" name="link"
                               value="<?= htmlspecialchars($book['link']) ?>"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Popis knihy</label>
                        <textarea name="description" rows="5"
                                  class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white focus:ring-2 focus:ring-[#b89f85]"><?= htmlspecialchars($book['description']) ?></textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">Obrázky (zatím neřešíme)</label>
                        <input type="file" name="images[]" multiple accept="image/*"
                               class="w-full p-2 border border-[#d6c7b4] rounded-md bg-white">
                    </div>

                </div>

            </div>

            <!-- Tlačítko -->
            <div class="pt-8">
                <button type="submit"
                        class="px-6 py-3 bg-[#d6bfa5] border border-[#b89f85] rounded-md
                               text-[#4a3f35] font-semibold shadow-sm hover:shadow-md
                               hover:bg-[#e2cfba] transition-all duration-200">
                    Uložit změny do DB
                </button>
            </div>

        </form>
    </div>
</div>

<?php require_once '../app/views/layout/footer.php'; ?>
</body>
</html>