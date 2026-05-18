<?php

class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    // 1. Registrace nového uživatele
    public function register(
        string $username, 
        string $email, 
        string $password, 
        ?string $firstName = null, 
        ?string $lastName = null, 
        ?string $nickname = null
    ): bool {
        // Kontrola, zda uživatel s tímto emailem už neexistuje
        if ($this->findByEmail($email)) {
            return false;
        }

        // Vytvoření bezpečného hashe z hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, first_name, last_name, nickname) 
                VALUES (:username, :email, :password, :first_name, :last_name, :nickname)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':nickname' => $nickname
        ]);
    }

    // 2. Nalezení uživatele podle emailu
    public function findByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 3. Získání uživatele podle ID
    public function findById(int $id) {
        $sql = "SELECT id, username, email, first_name, last_name, nickname, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace profilu uživatele
public function update(int $id, string $firstName, string $lastName, string $nickname): bool {
    $sql = "UPDATE users 
            SET first_name = :first_name,
                last_name = :last_name,
                nickname = :nickname
            WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':nickname' => $nickname
    ]);
}

    // Získání všech uživatelů
public function getAll() {
    $sql = "SELECT id, username, email, first_name, last_name, nickname, is_admin, created_at FROM users ORDER BY id ASC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Smazání uživatele
public function delete(int $id): bool {
    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':id' => $id]);
}
}