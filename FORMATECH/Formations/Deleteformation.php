<?php
$titre='Supprimer la promotion';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    Formation::delete($pdo, $id);
    header('Location: Formation_list.php');
}

if (isset($_GET['id'])) {
    $formationId = $_GET['id'];
    $existingFormation = Formation::getFormationById($pdo, $formationId);
} else {
    $existingFormation = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Formation::renderForm('delete', $existingFormation);

include '../includes/footer.php';
?>
