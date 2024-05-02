<?php
$titre="Supprimer l'intervenant";
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    Employe::delete($pdo, $id);
    header('Location: employes_list.php');
}

if (isset($_GET['id'])) {
    $employeId = $_GET['id'];
    $existingEmploye = Employe::getEmployeById($pdo, $employeId);
} else {
    $existingEmploye = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Employe::renderForm('delete', $existingEmploye);

include '../includes/footer.php';
