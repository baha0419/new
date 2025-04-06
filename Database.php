<?php
require_once 'Student.php';
require_once 'User.php';
require_once 'Section.php';
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $this->connection = new PDO(
                'mysql:host=localhost;dbname=student_management',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
    public static function getStudentById($id) {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return new Student(
            $data['id'],
            $data['name'],
            $data['birthday'],
            $data['image'],
            $data['section_id']
        );
    }
    public static function getAllStudents() {
        $db = self::getInstance();
        $stmt = $db->query("SELECT * FROM students");
        return array_map(function($data) {
            return new Student(
                $data['id'],
                $data['name'],
                $data['birthday'],
                $data['image'],
                $data['section_id']
            );
        }, $stmt->fetchAll());
    }

    public static function getSections() {
        $db = self::getInstance();
        $stmt = $db->query("SELECT * FROM sections");
        return array_map(function($data) {
            return new Section(
                $data['id'],
                $data['designation'],
                $data['description']
            );
        }, $stmt->fetchAll());
    }

    public static function getSectionById($id) {
        $db = self::getInstance();
        $stmt = $db->prepare("SELECT * FROM sections WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return new Section($data['id'], $data['designation'], $data['description']);
    }

}