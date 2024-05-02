<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre='Créer un étudiant';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $num_etudiant = $_POST['num_etudiant'];
    $promotions = isset($_POST['promotions']) ? $_POST['promotions'] : []; // Récupérer les promotions sélectionnées

    $success = Etudiant::creer($pdo, $prenom, $nom, $email, $date_naissance, $num_etudiant, $promotions); // Transmettre les promotions sélectionnées
    $message = $success ? 'Étudiant créé avec succès.' : 'Erreur lors de la création.';
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

// Récupérer toutes les promotions
$promotions = Promotion::getAll($pdo);

// Afficher le formulaire pour créer un nouvel étudiant avec les promotions
Etudiant::renderForm('creer', null, $promotions);

include '../includes/footer.php';
?>
