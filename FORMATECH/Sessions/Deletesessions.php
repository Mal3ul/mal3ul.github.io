<?php
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    $success = Session::delete($pdo, $id);
    $message = $success ? 'Session supprimée avec succès.' : 'Erreur dans la suppression.';
    header('Location:Sessions_list.php');
    exit();
} else {
    $message = 'Session ID invalide.';
}


if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];
    $existingSession = Session::getSessionById($pdo, $sessionId);
} else {
    $existingSession = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Session::renderForm('delete', $existingSession);

include '../includes/footer.php';
?>