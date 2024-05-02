<?php
session_start();
$titre ="Liste des Formations";
include '../includes/header.php';

$formations = Formation::getAll($pdo);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-16">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Durée de formation</th>
                        <th>Abréviation</th>
                        <th>Niveau RNCP</th>
                        <th>Privé / Public</th>
                        <th>Module(s)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($formations as $formation) : ?>
                        <tr>
                            <td><?= $formation->getId() ?></td>
                            <td><?= $formation->getNom() ?></td>
                            <td><?= $formation->getduree() ?></td>
                            <td><?= $formation->getAbreviation() ?></td>
                            <td><?= $formation->getNiveau() ?></td>
                            <td><?= ($formation->getis_public() ? 'Public' : 'Private') ?></td>
                            <td><?= $formation->getModules($pdo) ?></td>
                            <td>
                                <a href="deleteformation.php?id=<?= $formation->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette formation ?')">Supprimer</a>
                                <a href="modifyformation.php?id=<?= $formation->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="createformation.php" class="btn btn-primary">Créer une nouvelle formation</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>