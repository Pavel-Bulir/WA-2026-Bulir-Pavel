<?php require_once '../app/views/layout/header.php'; ?>

    <!-- Formulář -->
    <div class="bg-[#fcfaf7] border border-[#c8b8a6] shadow-xl shadow-[#b89f85]/40 rounded-lg p-8">

        <form action="<?= BASE_URL ?>/index.php?url=book/store" method="post" enctype="multipart/form-data">

            <!-- GRID 2 SLOUPCE -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- LEVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label for="title" class="block font-medium text-[#4a3f35] mb-1">
                            Název knihy <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="title" name="title" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="author" class="block font-medium text-[#4a3f35] mb-1">
                            Autor knihy <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="author" name="author" placeholder="Příjmení, jméno" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="isbn" class="block font-medium text-[#4a3f35] mb-1">ISBN</label>
                        <input type="number" id="isbn" name="isbn"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="year" class="block font-medium text-[#4a3f35] mb-1">
                            Rok vydání <span class="text-red-600">*</span>
                        </label>
                        <input type="number" id="year" name="year" required
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="price" class="block font-medium text-[#4a3f35] mb-1">Cena</label>
                        <input type="number" id="price" name="price" step="0.5"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                </div>

                <!-- PRAVÝ SLOUPEC -->
                <div class="space-y-6">

                    <div>
                        <label for="category" class="block font-medium text-[#4a3f35] mb-1">Kategorie</label>
                        <input type="text" id="category" name="category"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="subcategory" class="block font-medium text-[#4a3f35] mb-1">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="link" class="block font-medium text-[#4a3f35] mb-1">Odkaz</label>
                        <input type="text" id="link" name="link"
                               class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                      focus:ring-2 focus:ring-[#b89f85]">
                    </div>

                    <div>
                        <label for="description" class="block font-medium text-[#4a3f35] mb-1">Popis knihy</label>
                        <textarea id="description" name="description" rows="6"
                                  class="w-full p-3 border border-[#d6c7b4] rounded-md bg-white 
                                         focus:ring-2 focus:ring-[#b89f85]">Napište popis knihy</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-[#4a3f35] mb-1">
                            Obrázky (můžete nahrát více)
                        </label>

                        <label class="block p-4 border border-[#d6c7b4] rounded-md bg-white cursor-pointer
                                      hover:bg-[#f3ede4] transition">
                            <span class="block font-medium text-[#4a3f35]">Klikni pro výběr souborů</span>
                            <span class="block text-sm text-gray-600">JPG / PNG / WebP – více souborů najednou</span>
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

<?php require_once '../app/views/layout/footer.php'; ?>
</body>
</html>