<?php

class Book
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($title, $author, $year)
    {
        $query = "INSERT INTO books (title, author, year) VALUES (:title, :author, :year)";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':year' => $year
        ]);
    }
}
