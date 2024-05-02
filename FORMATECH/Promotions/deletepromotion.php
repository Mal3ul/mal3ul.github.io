<?php
$titre="Supprimer la promotion";
include '../includes/header.php';

$pdo = Database::getPDO();
$message = '';

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id !== null) {
    $success = Promotion::delete($pdo, $id);
    $message = $success ? 'Promotion supprimée avec succès.' : 'Erreur dans la suppression.';
    header('Location:Promotions_list.php');
    exit();
} else {
    $message = 'Invalid promotion ID.';
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

Promotion::renderForm('delete', $existingPromotion);

include '../includes/footer.php';
?>
