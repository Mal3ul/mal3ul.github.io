<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre ="Liste des promotions";
include '../includes/header.php';

$promotions = Promotion::getAll($pdo);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-16">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Année</th>
                        <th>Date de début</th>
                        <th>Date de fin</th>
                        <th>Formation(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $promotion) : ?>
                        <tr>
                            <td><?= $promotion->getId() ?></td>
                            <td><?= $promotion->getAnnee() ?></td>
                            <td><?= $promotion->getDateDebut() ?></td>
                            <td><?= $promotion->getDateFin() ?></td>
                            <td><?= implode(', ', $promotion->getFormations($pdo)) ?></td>


                            <td>
                                <a href="deletepromotion.php?id=<?= $promotion->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette promotion ?')">Supprimer</a>
                                <a href="modifypromotion.php?id=<?= $promotion->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="../Promotions/Createpromotion.php" class="btn btn-primary">Créer une promotion</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>