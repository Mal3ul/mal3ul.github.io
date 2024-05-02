<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre='Créer une promotion';
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formationId = $_POST['formationIds'];
    $annee = $_POST['annee'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    
    $success = Promotion::creer($pdo, $annee, $date_debut, $date_fin, $formationId);
    $message = $success ? 'Promotion créée avec succès.' : 'Erreur dans la création.';
}

if (isset($_GET['id'])) {
    $promotionId = $_GET['id'];
    $existingPromotion = Promotion::getPromotionById($pdo, $promotionId);
} else {
    $existingPromotion = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
}

Promotion::renderForm('creer', $existingPromotion);

include '../includes/footer.php';
?>

<?php if (!empty($message)) : ?>
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

