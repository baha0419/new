<?php
require_once 'Repository.php';

class UserRepository extends Repository {
    protected $table = 'users';

    // Méthode spécifique aux utilisateurs
    public function findByUsername(string $username): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}