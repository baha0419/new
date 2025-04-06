<?php
require_once 'User.php';
require_once 'Database.php';

class Auth {
    public static function login($username, $password) {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute(array($username, $password)); // Comparaison directe
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $_SESSION['user'] = new User(
                $userData['id'],
                $userData['username'],
                $userData['email'],
                $userData['role']
            );
            return true;
        }
        error_log("Échec de connexion pour: $username");
        return false;
    }

    public static function logout() {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function isAuthenticated() {
        return isset($_SESSION['user']);
    }

    public static function getUser() {
        if (!isset($_SESSION['user'])) return null;
        $data = $_SESSION['user'];
        return new User($data['id'], $data['username'], $data['email'], $data['role']);
    }

    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: login.php');
            exit;
        }
    }

    public static function requireAdmin() {
        self::requireAuth();
        $user = self::getUser();
        if (!$user instanceof User || !$user->isAdmin()) {
            header('Location: index.php');
            exit;
        }
    }
}