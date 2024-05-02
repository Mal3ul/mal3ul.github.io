<?php
$pdo = Database::getPDO();
$formations = Formation::getAll($pdo);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div hidden class="mb-2">
                    <label for="id" class="form-label"> ID:</label>
                    <input type="text" class="form-control" name="id" value="<?php echo $existingPromotion !== null ? $existingPromotion->getId() : ''; ?>" required readonly>
                </div>

                <div class="mb-2">
                    <label for="annee" class="form-label">Année :</label>
                    <input type="text" class="form-control" name="annee" value="<?php echo $annee; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date de début :</label>
                    <input type="date" value="<?php echo $annee.date('-m-d') ?>" max="<?php echo $annee ?>-12-31" class="form-control" name="date_debut" value="<?php echo $date_debut; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="date_fin" class="form-label">Date de fin :</label>
                    <input type="date" value="<?php echo $annee.date('-m-d') ?>" min ="<?php echo $annee ?>-01-01" max="<?php echo $annee ?>-12-31" class="form-control" name="date_fin" value="<?php echo $date_fin; ?>" required>
                </div>

                <div class="mb-3">
    <label for="formationIds" class="form-label">Formation(s) associée(s) :</label>
    <?php if (!empty($formations)) : ?>
        <?php foreach ($formations as $formation) : ?>
            <div class="form-check" multiple>
                <input class="form-check-input" type="checkbox" name="formationIds[]" value="<?php echo $formation->getId(); ?>">
                <label class="form-check-label"><?php echo $formation->getNom(); ?></label>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Aucune formation disponible.</p>
    <?php endif; ?>
</div>




 
                <button type="submit" class="btn btn-primary">
                    <?php echo $type === 'creer' ? 'Créer' : 'Modifer'; ?>
                </button>
        <a href="Promotions_list.php" class="btn btn-primary">Retour</a>
            </form>
        </div>
    </div>
</div>
