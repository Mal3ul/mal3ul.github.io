<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre = "Modifier le module";
include '../includes/header.php';

$message = '';
$formations= Formation::getAll($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $module = Module::getModuleByIds($pdo, $_POST['id']);
    $success = $module->update($pdo, $_POST['nom'], $_POST['duree'], $_POST['formations']);

    $message = $success ? 'Module modifié avec succès.' : 'Erreur dans la mise à jour du module.';
}

if (isset($_GET['id'])) {
    $moduleId = $_GET['id'];
    $existingModule = Module::getModuleByIds($pdo, $moduleId);
} else {
    $existingModule = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}


Module::renderForm('modifier', $existingModule);

include '../includes/footer.php';
?>
