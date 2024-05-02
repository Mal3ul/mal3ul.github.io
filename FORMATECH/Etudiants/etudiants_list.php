<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre ="Liste des Etudiants";
include '../includes/header.php';

$etudiants = Etudiant::getAll($pdo);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-16">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Date de Naissance</th>
                        <th>Numéro Etudiant</th>
                        <th>Promo(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($etudiants as $etudiant) : ?>
                        <tr>
                            <td><?= $etudiant->getId() ?></td>
                            <td><?= $etudiant->getNom() ?></td>
                            <td><?= $etudiant->getPrenom() ?></td>
                            <td><?= $etudiant->getEmail() ?></td>
                            <td><?= $etudiant->getDateNaissance() ?></td>
                            <td><?= $etudiant->getNum()?></td>
                            <td><?= $etudiant->getPromotionId() ?></td>
                            <td>
                                <a href="Deleteetudiants.php?id=<?= $etudiant->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cet(te) étudiant(e) ?')">Supprimer</a>
                                <a href="modifyetudiants.php?id=<?= $etudiant->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="Createetudiants.php" class="btn btn-primary">Créer un(e) nouvel(le) étudiant(e)</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>