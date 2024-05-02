<?php
session_start();
if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
    
    header('Location: ../index.php');
    exit();
}

$titre='Créer un employé';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $session = '1';

    $success = Employe::creer($pdo, $prenom, $nom, $email, $session);
    $message = $success ? 'Employé(e) créé(e) avec succès.' : 'Erreur dans la création.';
}

if (isset($_GET['id'])) {
    $intervenantId = $_GET['id'];
    $existingEmploye = Employe::getEmployeById($pdo, $employeId);
} else {
    $existingEmploye = null;
}


if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Employe::renderForm('creer', $existingEmploye);

include '../includes/footer.php';
?>

<?php if (!empty($message)) : ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

