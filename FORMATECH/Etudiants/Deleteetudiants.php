<?php
$titre="Supprimer l'étudiant";
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    Etudiant::delete($pdo, $id);
    header('Location: Etudiants_list.php');
}

if (isset($_GET['id'])) {
    $EtudiantId = $_GET['id'];
    $existingEtudiant = Etudiant::getEtudiantById($pdo, $EtudiantId);
} else {
    $existingEtudiant = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Etudiant::renderForm('delete', $existingEtudiant);

include '../includes/footer.php';
