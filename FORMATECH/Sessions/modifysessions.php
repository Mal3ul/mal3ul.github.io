<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre="Modifier la session";
include '../includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionId = isset($_POST['id']) ? $_POST['id'] : null;

    if ($sessionId) {
        $session = Session::getSessionById($pdo, $_POST['id']);
        $success = $session->update($pdo, $_POST['date'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['modules'], $_POST['promos'], $_POST['intervenants']);
        $message = $success ? 'Session modifiée avec succès.' : 'Erreur dans la mise à jour.';
    } else {
        $message = 'ID session invalide.';
    }
}

if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];
    $existingSession = Session::getSessionById($pdo, $sessionId);
} else {
    $existingSession = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
    header('Refresh:3; url=sessions_list.php');
}

Session::renderForm('modifier', $existingSession);

include '../includes/footer.php';
?>