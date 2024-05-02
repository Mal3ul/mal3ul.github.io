<?php
if (!isset($_SESSION['profil'])) {
    
    header('Location: ../index.php');
    exit();
}

$pdo = Database::getPDO();
$formations = Formation::getAll($pdo);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-2">
                    <label for="id" class="form-label">ID :</label>
                    <input type="text" class="form-control" name="id" value="<?php echo $existingModule !== null ? $existingModule->getId() : ''; ?>" required readonly>
                </div>

                <div class="mb-2">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo $nom; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="duree" class="form-label">Durée:</label>
                    <input type="text" class="form-control" name="duree" value="<?php echo $duree; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="formations" class="form-label">Formations associées :</label>
                    <?php foreach ($formations as $formation) : ?>
                <div class="form-control">
                    <input type="checkbox" name="formations[]" value="<?php echo $formation->getId(); ?>">
                    <label><?php echo $formation->getNom(); ?></label>
                </div>
                    <?php endforeach; ?>
                </div>

 
                <button type="submit" class="btn btn-primary">
                    <?php echo $type === 'creer' ? 'Creer Module' : 'Modifier Module'; ?>
                </button>

                 <a href="Module_list.php" class="btn btn-primary">Retour</a>
            </form>
        </div>
    </div>
</div>
