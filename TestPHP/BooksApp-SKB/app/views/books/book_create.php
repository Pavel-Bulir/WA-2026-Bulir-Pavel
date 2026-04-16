<?php require_once '../app/views/layout/header.php'; ?>

<body class="font-serif text-gray-800">

<div class="max-w-5xl mx-auto px-6 py-10">

    <!-- Nadpis -->
    <div class="mb-10">
        <h2 class="text-4xl font-bold text-[#4a3f35] mb-3">
            Přidat novou knihu
        </h2>

        <p class="text-gray-700 text-lg">
            Vyplňte údaje a uložte novou knihu do databáze.
        </p>
    </div>

    <!-- Formulář -->
    <div class="bg-[#fcfaf7] border border-[#c8b8a6] shadow-xl shadow-[#b89f85]/40 rounded-lg p-8">

        <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- LEVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label for="title" class="block font-medium text-[#4a3f35] mb-1">
                            Název knihy <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="title" name="title" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="author" class="block font-medium text-[#4a3f35] mb-1">
                            Autor knihy <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="author" name="author" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="isbn" class="block font-medium text-[#4a3f35] mb-1">ISBN</label>
                        <input type="number" id="isbn" name="isbn"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="year" class="block font-medium text-[#4a3f35] mb-1">
                            Rok vydání <span class="text-red-600">*</span>
                        </label>
                        <input type="number" id="year" name="year" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="price" class="block font-medium text-[#4a3f35] mb-1">Cena</label>
                        <input type="number" id="price" name="price" step="0.5"
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
                                <option value="<?= htmlspecialchars($cat['id']) ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="subcategory" class="block font-medium text-[#4a3f35] mb-1">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="link" class="block font-medium text-[#4a3f35] mb-1">Odkaz</label>
                        <input type="text" id="link" name="link"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                               focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="description" class="block font-medium text-[#4a3f35] mb-1">Popis knihy</label>
                        <textarea id="description" name="description" rows="6"
                                  class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white text-[#4a3f35]
                                  focus:ring-2 focus:ring-[#b89f85]">Napište popis knihy</textarea>
                    </div>

                    <!-- Obrázky -->
                    <div>
                        <label class="block text-xs font-semibold text-[#4a3f35] mb-2 uppercase tracking-wider">
                            Obrázky knihy
                        </label>

                        <label for="images"
                               class="flex flex-col items-center justify-center w-full h-24 border-2 border-[#4a3f35] border-dashed rounded-lg cursor-pointer bg-white hover:bg-[#f3ede4] transition-colors">

                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span id="file-title" class="text-sm text-[#4a3f35] font-semibold">
                                    Klikni pro výběr souborů
                                </span>
                                <span id="file-info" class="text-xs text-[#4a3f35] mt-1 text-center px-4">
                                    Žádné soubory nebyly vybrány
                                </span>
                            </div>

                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden">
                        </label>
                    </div>

                </div>

            </div>

            <!-- Tlačítko -->
            <div class="pt-8">
                <button type="submit"
                        class="px-6 py-3 bg-[#d6bfa5] border border-[#b89f85] rounded-md
                        text-[#4a3f35] font-semibold shadow-sm hover:shadow-md
                        hover:bg-[#e2cfba] transition-all duration-200">
                    Odeslat
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const fileInput = document.getElementById('images');
    const fileTitle = document.getElementById('file-title');
    const fileInfo = document.getElementById('file-info');

    fileInput.addEventListener('change', function(event) {
        const files = event.target.files;

        if (files.length === 0) {
            fileTitle.textContent = 'Klikněte pro výběr souborů';
            fileInfo.textContent = 'Žádné soubory nebyly vybrány';
        } else if (files.length === 1) {
            fileTitle.textContent = 'Soubor připraven';
            fileInfo.textContent = files[0].name;
        } else {
            fileTitle.textContent = 'Soubory připraveny';
            fileInfo.textContent = 'Vybráno celkem: ' + files.length + ' souborů';
        }
    });
</script>

<?php require_once '../app/views/layout/footer.php'; ?>

</body>
</html>
