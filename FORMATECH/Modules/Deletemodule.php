<?php
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if ($id) {
        $success = Module::delete($pdo, $id);
        $message = $success ? 'Module deleted successfully.' : 'Erreur dans la suppression.';
        header('Location: Module_list.php');
        exit();
    } else {
        $message = 'Invalid module ID.';
    }
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

Module::renderForm('delete', $existingModule);

include '../includes/footer.php';
?>