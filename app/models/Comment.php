<?php

class Comment {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Uložení nového komentáře
    public function store(int $trip_id, int $user_id, string $content): bool {
        $sql = "INSERT INTO comments (trip_id, user_id, content) 
                VALUES (:trip_id, :user_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':trip_id' => $trip_id,
            ':user_id' => $user_id,
            ':content' => $content
        ]);
    }

    public function getById(int $id) {
    $sql = "SELECT * FROM comments WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $content): bool {
    $sql = "UPDATE comments SET content = :content WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':content' => $content
    ]);
    }

    // Získání všech komentářů k výletu
    public function getByTripId(int $trip_id) {
        $sql = "SELECT comments.*, users.username, users.nickname 
                FROM comments 
                LEFT JOIN users ON comments.user_id = users.id 
                WHERE comments.trip_id = :trip_id 
                ORDER BY comments.created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':trip_id' => $trip_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Smazání komentáře
    public function delete(int $id): bool {
        $sql = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}