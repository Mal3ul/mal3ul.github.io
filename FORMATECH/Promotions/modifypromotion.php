<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre="Modifier la promotion";
include '../includes/header.php';

$message = '';
$formations= Formation::getAll($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promotion = Promotion::getPromotionById($pdo, $_POST['id']);
    $success = $promotion->update($pdo, $_POST['annee'], $_POST['date_debut'], $_POST['date_fin'], $_POST['formationIds']);
    $message = $success ? 'Promotion modifiée avec succès.' : 'Erreur dans la mise à jour.';
}


if (isset($_GET['id'])) {
    $promotionId = $_GET['id'];
    $existingPromotion = Promotion::getPromotionById($pdo, $promotionId);
} else {
    $existingPromotion = null;
}

if (!empty($message)) {
    echo '<p>' . htmlspecialchars($message) . '</p>';
    header('Refresh:5; url=Promotions_list.php');
}

Promotion::renderForm('modifier', $existingPromotion);

include '../includes/footer.php';
?>