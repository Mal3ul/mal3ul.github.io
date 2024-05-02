<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-2">
                    <label for="id" class="form-label">ID :</label>
                    <input type="text" class="form-control" name="id" value="<?php echo $existingIntervenant !== null ? $existingIntervenant->getId() : ''; ?>" required readonly>
                </div>

                <div class="mb-2">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo $nom; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" name="prenom" value="<?php echo $prenom; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="session" class="form-label">Session :</label>
                    <select class="form-select" name="session">
                        
                    </select>
                </div>
 
                <button type="submit" class="btn btn-primary">
                    <?php echo $type === 'creer' ? 'Créer' : 'Modifier'; ?>
                </button>
        <a href="intervenants_list.php" class="btn btn-primary">Retour</a>
            </form>
        </div>
    </div>
</div>
