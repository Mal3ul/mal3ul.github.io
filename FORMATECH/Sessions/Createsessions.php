<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre='Créer une session';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];
    $modules = $_POST['modules'];
    $promos = $_POST['promos'];
    $intervenants = $_POST['intervenants'];

    $success = Session::creer($pdo, $date, $heure_debut, $heure_fin, $modules, $promos, $intervenants);
    $message = $success ? 'Session créée avec succès.' : 'Erreur dans la création.';
}

if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];
    $existingSession = Session::getsessionById($pdo, $sessionId);
} else {
    $existingSession = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Session::renderForm('creer', $existingSession);

include '../includes/footer.php';
?>

<?php if (!empty($message)) : ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

