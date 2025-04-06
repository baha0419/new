<?php
require_once 'Auth.php';

    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    
    if (Auth::login($username, $password)) {
        header('Location: index.php');
    }
    $error = "Identifiants incorrects";
    echo($error);
?>