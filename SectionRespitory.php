<?php
require_once 'Repository.php';

class SectionRepository extends Repository {
    protected $table = 'sections';

    // Méthode spécifique aux sections si nécessaire
    public function findByDesignation(string $designation): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE designation = ?");
        $stmt->execute([$designation]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}