<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre='Créer un intervenant';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $session = '1';

    $success = Intervenant::creer($pdo, $prenom, $nom, $email, $session);
    $message = $success ? 'Intervenant(e) créé(e) avec succès.' : 'Erreur dans la création.';
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

Intervenant::renderForm('creer', $existingIntervenant);

include '../includes/footer.php';
?>

<?php if (!empty($message)) : ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

