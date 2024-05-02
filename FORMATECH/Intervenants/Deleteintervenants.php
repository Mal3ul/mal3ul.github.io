<?php
$titre="Supprimer l'intervenant";
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    Intervenant::delete($pdo, $id);
    header('Location: Intervenants_list.php');
}

if (isset($_GET['id'])) {
    $intervenantId = $_GET['id'];
    $existingIntervenant = Intervenant::getIntervenantById($pdo, $intervenantId);
} else {
    $existingIntervenant = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Intervenant::renderForm('delete', $existingIntervenant);

include '../includes/footer.php';
