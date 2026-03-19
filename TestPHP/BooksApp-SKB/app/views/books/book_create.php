<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            <h2>Přidat novou knihu</h2>
            <p> Vyplňte údaje a uložte novou knihu do databáze.</p>

        </div>

        <div>
            <form action="">
                <div>
                    <div>
                        <label for="title">Název knihy<span> *</span></label>
                        <input type="text" id="title" name="title" required> <!-- required = nejde odeslat, dokud nebude vyplněný -->
                    </div>
                    <div>
                        <label for="author">Autor knihy<span> *</span></label>
                        <input type="text" id="author" name="author" placeholder="Příjmení, jméno" required> <!-- id je pro javascript, name je pro css| Placeholder dělá šedej text v poli na psaní, který zmizí, když se do něj začne psát (jako příklad co se do toho píše) -->
                    </div>
                     <div>
                        <label for="isbn">ISBN</label>
                        <input type="number" id="isbn" name="isbn" > 
                    </div>
                    <div>
                        <label for="category">Kategorie</label>
                        <input type="text" id="category" name="category">
                    </div>
                    <div>
                        <label for="subcategory">Podkategorie</label>
                        <input type="text" id="subcategory" name="subcategory">
                    </div>
                    <div>
                        <label for="year">Rok vydání<span> *</span></label>
                        <input type="number" id="year" name="year" required>
                    </div>
                    <div>
                        <label for="price">Cena</label>
                        <input type="number" id="price" name="price" step ="0.5"> <!-- step = když měníme čísla v poli pomocí šipek, tak step nám ovlivňuje o kolik se to změní zmáčknutím šipky -->
                    </div>
                     <div>
                        <label for="link"><span>Odkaz</span></label>
                        <input type="number" id="link" name="link" >
                    </div>
                     <div>
                        <label for="description">Popis knihy</label>
                        <textarea name="description" id="description" rows="10">Napište popis knihy</textarea> <!-- textarea, vytvoří velké pole, do kterého se může psát, je to stejné jako input jenom větší | rows a cols, nám říká jak ze začátku bude velké to pole -->
                    </div>
                    <div>
                        <label >Obrázky (můžete nahrát více)</label>
                        <label >
                            <span >Klikni pro výběr souborů</span>
                            <span >JPG / PNG / WebP – více souborů najednou</span>
                            <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden"> <!-- images[] = bude tam nahráno více obrázků | type je file = není to ani text ani číslo ale bude se tam vkládat nějakej soubor -->
                        </label>
                    </div>
                </div>

                <div>
                    <div>
                        <button type ="submit">Odeslat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>