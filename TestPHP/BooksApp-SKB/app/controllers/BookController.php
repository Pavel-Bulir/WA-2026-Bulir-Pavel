<?php

class BookController {

    //0. Výchozí metoda pro zobrazení úvodní stránky
    public function index () {

    //V dalwích krocích se zde přidá komunikace s Modelem pro získáníá dat z databáze
    //např. při načtení všech uložených knih

    //nyní se pouze načte (vloží) připravený soubor s HTML strukturou
        require_once '../app/views/books/books_list.php';
    }
}

public function store()
{
    // 1) Načtení dat z formuláře
    $title = $_POST['title'] ?? null;
    $author = $_POST['author'] ?? null;
    $year = $_POST['year'] ?? null;

    // 2) Validace
    if (!$title || !$author) {
        echo "Chybí povinná pole.";
        return;
    }

    // 3) Model
    $db = Database::getConnection();
    $bookModel = new Book($db);

    // 4) Uložení
    $bookModel->create($title, $author, $year);

    // 5) Přesměrování
    header("Location: /books");
    exit;
}
