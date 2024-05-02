<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre = "Modifier l'intervenant";
include '../includes/header.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $intervenant = Intervenant::getIntervenantById($pdo, $_POST['id']);
    $success = $intervenant->update($pdo, $_POST['nom'], $_POST['prenom'], $_POST['email'], '1');
    if ($success) {
        $message = 'Intervenant(e) modifié(e) avec succès.';
        echo '<p>' . htmlspecialchars($message) . '</p>';
        header('Refresh:3; url=intervenants_list.php'); // Refresh the page after 3 seconds and redirect to intervenants_list.php
        exit;
    }else{
        echo 'Erreur dans la mise à jour.';
        header('Refresh:3; url=intervenants_list.php');
    }
}

if (isset($_GET['id'])) {
    $intervenantId = $_GET['id'];
    $existingIntervenant = Intervenant::getIntervenantById($pdo, $intervenantId);
} else {
    $existingIntervenant = null;
}


// if (!empty($message)) {
//     echo '<p>' . htmlspecialchars($message) . '</p>';
// }

Intervenant::renderForm('modifier',$existingIntervenant);

include '../includes/footer.php'; 
?>