<?php
class CnxEtudiant {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $db   = 'student_db';
        $user = 'root';
        $pass = ''; 
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getAllStudents() {
        $stmt = $this->pdo->query("SELECT * FROM student");
        return $stmt->fetchAll();
    }
}
?>
