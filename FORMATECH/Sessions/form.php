<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-2">
                    <label for="id" class="form-label"> ID:</label>
                    <input type="text" class="form-control" name="id" value="<?php echo $existingSession !== null ? $existingSession->getId() : ''; ?>" required readonly>
                </div>

                <div class="mb-2">
                    <label for="date" class="form-label">Date :</label>
                    <input type="date" class="form-control" name="date" value="<?php echo $date; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="heure_debut" class="form-label">Heure de début :</label>
                    <input type="time" min="08:00" max="17:00"class="form-control" name="heure_debut" value="<?php echo $heure_debut; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="heure_fin" class="form-label">Heure de fin :</label>
                    <input type="time" min="09:00" max="18:00" class="form-control" name="heure_fin" value="<?php echo $heure_fin; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="modules" class="form-label">Module(s) associé(s) :</label>
                    <input type="text" class="form-control" name="modules" value="<?php echo $modules; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="promos" class="form-label">Promo(s) associée(s) :</label>
                    <input type="text" class="form-control" name="promos" value="<?php echo $promos; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="intervenants" class="form-label">Intervenant(es) associé(es) :</label>
                    <input type="text" class="form-control" name="intervenants" value="<?php echo $intervenants; ?>" required>
                </div>
 
                <button type="submit" class="btn btn-primary">
                    <?php echo $type === 'creer' ? 'Créer' : 'Modifer'; ?>
                </button>
        <a href="sessions_list.php" class="btn btn-primary">Retour</a>
            </form>
        </div>
    </div>
</div>
