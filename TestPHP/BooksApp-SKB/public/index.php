<?php

// Nastartování relací pro ukládání dočasných dat (Flash zprávy)
session_start();

// ... zbytek souboru index.php zůstává stejný ...

//pro účely výuky a ladění na lokálním serveru (např. XAMPP)
// je vhodné zapnout kompletní zobrazování chyb.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Dynamické zjištění základní adresy aplikace
// Vypočítá absolutní cestu ke složce, ve které běží tento index.php
$baseDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', $baseDir);



//Načtení třídy routeru, která
require_once '../core/App.php';
$app = new App();


