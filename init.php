<?php
// Start session only if not already active
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Load required classes
require_once 'Database.php';
require_once 'User.php';
require_once 'Auth.php';
?>