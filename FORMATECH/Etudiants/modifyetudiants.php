<?php
session_start();
if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'gest') {
    
    header('Location: ../index.php'); // Remplacez "autre_page.php" par la page vers laquelle vous souhaitez rediriger
    exit();
}

$titre = "Modifier l'étudiant";
include '../includes/header.php';  

$currentPromotionIds = [];
$pdo = Database::getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{    
    $etudiant = Etudiant::getEtudiantById($pdo, $_POST['id']);
    $success = $etudiant->update($pdo, $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['date_naissance'], $_POST['num_etudiant']);

    // Mise à jour de l'association de promotion, si une promotion est sélectionnée
    if ($success && isset($_POST['promotions'])) {
        // Supposons que vous avez une méthode dans EtudiantPromotion pour gérer la mise à jour de l'association
        EtudiantPromotion::updateEtudiantPromotion($pdo, $etudiant->getId(), $_POST['promotions']);
        $message = 'Etudiant(e) et sa promotion modifiés avec succès.';
    } elseif ($success) {
        $message = 'Etudiant(e) modifié(e) avec succès, mais sans modification de la promotion.';
    } else {
        $message = 'Erreur dans la mise à jour.';
    }

    echo '<p>' . htmlspecialchars($message) . '</p>';
    header('Refresh:3; url=etudiants_list.php'); // Refresh the page after 3 seconds and redirect to etudiants_list.php
    exit;
}

if (isset($_GET['id'])) {
    $etudiantId = $_GET['id'];
    $existingEtudiant = Etudiant::getEtudiantById($pdo, $etudiantId);
    // Supposons que vous avez une méthode pour obtenir la promotion actuelle de l'étudiant
    $currentPromotionIds = EtudiantPromotion::getPromotionForEtudiant($pdo, $etudiantId);
    $currentPromotionId = !empty($currentPromotionIds) ? $currentPromotionIds[0] : null;
} else {
    $existingEtudiant = null;
    $currentPromotionId = null;
}

$promotions = Promotion::getAll($pdo);

Etudiant::renderForm('Modifier', $existingEtudiant, $currentPromotionId);

include '../includes/footer.php'; 
?>
