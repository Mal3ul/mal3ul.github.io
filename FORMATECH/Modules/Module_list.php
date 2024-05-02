<?php
session_start();
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$titre ="Liste des modules";
include '../includes/header.php';

$modules = Module::getAll($pdo);
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-16">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Durée du module</th>
                        <th>Formation associée</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modules as $module) : ?>
                        <tr>
                            <td><?= $module->getId() ?></td>
                            <td><?= $module->getNom() ?></td>
                            <td><?= $module->getduree() ?></td>
                            <td><?= $module->getFormations($pdo) ?></td>
                            
                            <td>
                                <a href="deletemodule.php?id=<?= $module->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de voilour supprimer cette module ?')">Supprimer</a>
                                <a href="modifymodule.php?id=<?= $module->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="createmodule.php" class="btn btn-primary">Créer un nouveau module</a>
            </div>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>