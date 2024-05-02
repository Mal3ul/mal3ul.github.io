<?php
session_start();
if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
    
    header('Location: ../index.php');
    exit();
}
$titre = "Modifier l'Employe";
include '../includes/header.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $employe = Employe::getEmployeById($pdo, $_POST['id']);
    $success = $employe->update($pdo, $_POST['nom'], $_POST['prenom'], $_POST['poste'], $_POST['email']);
    if ($success) {
        $message = 'Employe(e) modifié(e) avec succès.';
        echo '<p>' . htmlspecialchars($message) . '</p>';
        header('Refresh:3; url=employes_list.php'); // Refresh the page after 3 seconds and redirect to Employes_list.php
        exit;
    }else{
        echo 'Erreur dans la mise à jour.';
        header('Refresh:3; url=employes_list.php');
    }
}

if (isset($_GET['id'])) {
    $employeId = $_GET['id'];
    $existingEmploye = Employe::getEmployeById($pdo, $employeId);
} else {
    $existingEmploye = null;
}


// if (!empty($message)) {
//     echo '<p>' . htmlspecialchars($message) . '</p>';
// }

Employe::renderForm('modifier',$existingEmploye);

include '../includes/footer.php'; 
?>