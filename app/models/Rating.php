<?php

class Rating {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Uložení nebo aktualizace hodnocení
    public function store(int $trip_id, int $user_id, int $rating): bool {
        // INSERT OR UPDATE – pokud hodnocení existuje, aktualizuje ho
        $sql = "INSERT INTO ratings (trip_id, user_id, rating) 
                VALUES (:trip_id, :user_id, :rating)
                ON DUPLICATE KEY UPDATE rating = :rating2";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':trip_id' => $trip_id,
            ':user_id' => $user_id,
            ':rating' => $rating,
            ':rating2' => $rating
        ]);
    }

    // Průměrné hodnocení výletu
    public function getAverageByTripId(int $trip_id) {
        $sql = "SELECT ROUND(AVG(rating), 1) AS average, COUNT(*) AS count 
                FROM ratings WHERE trip_id = :trip_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':trip_id' => $trip_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Hodnocení konkrétního uživatele
    public function getUserRating(int $trip_id, int $user_id) {
        $sql = "SELECT rating FROM ratings 
                WHERE trip_id = :trip_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':trip_id' => $trip_id, ':user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}