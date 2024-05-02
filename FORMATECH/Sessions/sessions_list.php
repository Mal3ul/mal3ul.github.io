<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre ="Liste des sessions";
include '../includes/header.php';

$sessions = Session::getAll($pdo);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-16">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                        <th>Module(s)</th>
                        <th>Promo(s)</th>
                        <th>Intervenant(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sessions as $session) : ?>
                        <tr>
                            <td><?= $session->getId() ?></td>
                            <td><?= $session->getDate() ?></td>
                            <td><?= $session->getDebut() ?></td>
                            <td><?= $session->getFin() ?></td>
                            <td><?= $session->getModules() ?></td>
                            <td><?= $session->getPromos() ?></td>
                            <td><?= $session->getIntervenants() ?></td>
                            <td>
                                <a href="Deletesessions.php?id=<?= $session->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette session ?')">Supprimer</a>
                                <a href="modifysessions.php?id=<?= $session->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="../Sessions/Createsessions.php" class="btn btn-primary">Créer une session</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>