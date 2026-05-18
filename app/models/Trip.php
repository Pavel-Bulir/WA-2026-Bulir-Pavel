<?php

class Trip {
    // Připojení k databázi
    private PDO $db;

    // Konstruktor – přijme připojení k databázi a uloží ho
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Metoda pro uložení nového výletu do databáze
    public function store(
    string $name,           // název výletu – musí být text
    float $distance,        // délka trasy – může mít desetinná místa
    int $duration,          // doba trvání – celé číslo
    string $duration_unit,  // jednotka doby trvání – hod nebo dny
    int $difficulty_id,     // ID obtížnosti z tabulky difficulties
    string $location,       // místo/region
    string $route_url,      // odkaz na trasu
    ?string $attractions,   // zajímavosti – ? znamená že může být null (nepovinné)
    ?string $suitable_for,  // vhodné pro – JSON string, může být null
    int $no_dogs,           // zákaz psů – 0 nebo 1
    ?string $notes,         // poznámky – může být null
    ?string $images         // fotky – JSON string, může být null
): bool {                   // : bool znamená že metoda vrátí true nebo false

    // SQL dotaz pro vložení nového záznamu
    // Používáme :nazev místo přímých hodnot – ochrana proti SQL injection
    $sql = "INSERT INTO trips (name, distance, duration, duration_unit, difficulty_id, location, route_url, attractions, suitable_for, no_dogs, notes, images)
            VALUES (:name, :distance, :duration, :duration_unit, :difficulty_id, :location, :route_url, :attractions, :suitable_for, :no_dogs, :notes, :images)";

    // Připravíme dotaz – databáze ho zkontroluje ještě před spuštěním
    $stmt = $this->db->prepare($sql);

    // Spustíme dotaz a dosadíme skutečné hodnoty místo :nazev zástupců
    // Vrátí true pokud se uložení povedlo, false pokud ne
    return $stmt->execute([
        ':name' => $name,
        ':distance' => $distance,
        ':duration' => $duration,
        ':duration_unit' => $duration_unit,
        ':difficulty_id' => $difficulty_id,
        ':location' => $location,
        ':route_url' => $route_url,
        ':attractions' => $attractions,
        ':suitable_for' => $suitable_for,
        ':no_dogs' => $no_dogs,
        ':notes' => $notes,
        ':images' => $images
    ]);
    }

    
    // Získání všech knih z databáze
    public function getAll() {
    // JOIN spojí tabulku trips s tabulkou difficulties
    // díky tomu dostaneme název obtížnosti místo jen ID
    $sql = "SELECT trips.*, difficulties.name AS difficulty_name 
            FROM trips 
            LEFT JOIN difficulties ON trips.difficulty_id = difficulties.id 
            ORDER BY trips.id DESC";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získání jednoho konkrétního výletu podle jeho ID
public function getById($id) {
    $sql = "SELECT trips.*, difficulties.name AS difficulty_name 
            FROM trips 
            LEFT JOIN difficulties ON trips.difficulty_id = difficulties.id 
            WHERE trips.id = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    
    // Používá se fetch() místo fetchAll(), protože očekáváme maximálně jeden výsledek.
    // Vrátí asociativní pole s daty výletu, nebo false, pokud výlet neexistuje.
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Aktualizace existujícího výletu
public function update(
    $id, $name, $distance, $duration, $duration_unit,
    $difficulty_id, $location, $route_url, $attractions,
    $suitable_for, $no_dogs, $notes, $images = null
) {
    $sql = "UPDATE trips 
            SET name = :name, 
                distance = :distance,
                duration = :duration,
                duration_unit = :duration_unit,
                difficulty_id = :difficulty_id,
                location = :location,
                route_url = :route_url,
                attractions = :attractions,
                suitable_for = :suitable_for,
                no_dogs = :no_dogs,
                notes = :notes,
                images = :images
            WHERE id = :id";
            
    $stmt = $this->db->prepare($sql);

    // Parametrů je stejné množství jako u store, navíc je pouze :id
    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':distance' => $distance,
        ':duration' => $duration,
        ':duration_unit' => $duration_unit,
        ':difficulty_id' => $difficulty_id,
        ':location' => $location,
        ':route_url' => $route_url,
        ':attractions' => $attractions,
        ':suitable_for' => $suitable_for,
        ':no_dogs' => $no_dogs,
        ':notes' => $notes,
        ':images' => $images
    ]);
}

// Trvalé smazání výletu z databáze
public function delete($id) {
    $sql = "DELETE FROM trips WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    
    // Vrací true při úspěchu, false při chybě
    return $stmt->execute([':id' => $id]);
}
}