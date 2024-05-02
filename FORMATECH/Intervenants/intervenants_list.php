<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}
$titre ="Liste des intervenants";
include '../includes/header.php';

$intervenants = Intervenant::getAll($pdo);
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
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($intervenants as $intervenant) : ?>
                        <tr>
                            <td><?= $intervenant->getId() ?></td>
                            <td><?= $intervenant->getNom() ?></td>
                            <td><?= $intervenant->getPrenom() ?></td>
                            <td><?= $intervenant->getEmail() ?></td>
                            <td><?= $intervenant->getSession() ?></td>
                            <td>
                                <a href="Deleteintervenants.php?id=<?= $intervenant->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cet(te) intervenant(e) ?')">Supprimer</a>
                                <a href="modifyintervenants.php?id=<?= $intervenant->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="Createintervenants.php" class="btn btn-primary">Créer un(e) nouvel(le) intervenant(e)</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>