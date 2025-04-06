<?php
require_once 'User.php';
require_once 'Database.php';
require_once 'Auth.php';
session_start();
// Redirection basée sur l'authentification

if (Auth::isAuthenticated()) {
    $user = Auth::getUser();
    if ($user->isAdmin()) {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: user_dashboard.php');
    }
}

// Only redirect to login if not authenticated
else {
header('Location: login.php');}
?>