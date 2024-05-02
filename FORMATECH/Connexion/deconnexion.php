<?php
session_start();

// Détruit toutes les données de session
// $_SESSION = array();

session_destroy();

header('Location: ../index.php');
exit();
?>
