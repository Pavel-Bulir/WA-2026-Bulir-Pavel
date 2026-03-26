<?php

//pro účely cýuky a ladění na lokálmním serveru (např. XAMPP)
// je vhodné zapnout kompletní zovrazování chyb.

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Načtení třiídy routeru, která
require_once '../core/App.php';
$app = new App();