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