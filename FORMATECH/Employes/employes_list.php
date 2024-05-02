<?php
session_start();

if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
$titre ="Liste des employes";
include '../includes/header.php';

$employes = Employe::getAll($pdo);
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
                        <th>Poste</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($employes as $employe) : ?>
                        <tr>
                            <td><?= $employe->getId() ?></td>
                            <td><?= $employe->getNom() ?></td>
                            <td><?= $employe->getPrenom() ?></td>
                            <td><?= $employe->getPoste() ?></td>
                            <td><?= $employe->getEmail() ?></td>
                            <td>
                                <a href="Deleteemployes.php?id=<?= $employe->getId() ?>" class="btn btn-danger" onclick="return confirm('Etes-vous sûr de vouloir supprimer cet(te) employé(e) ?')">Supprimer</a>
                                <a href="modifyemployes.php?id=<?= $employe->getId() ?>" class="btn btn-primary" style="margin-left: 10px;">Modifier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="Createemployes.php" class="btn btn-primary">Créer un(e) nouvel(le) employé(e)</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>