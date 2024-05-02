<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre = "Créer un module";
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $success = Module::creer($pdo, $_POST['nom'], $_POST['duree'], $_POST['formations']);
    $message = $success ? 'Module created successfully.' : 'Erreur dans la création du module.';
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

Module::renderForm('creer', $existingModule);

include '../includes/footer.php';
?>

<?php if (!empty($message)) : ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
<?php endif; ?>
