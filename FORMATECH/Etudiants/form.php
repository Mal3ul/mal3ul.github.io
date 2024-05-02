<?php
$pdo = Database::getPDO();
$promotions = Promotion::getAll($pdo);
$currentPromotionIds = []; // Tableau pour stocker les identifiants des promotions actuelles de l'étudiant

// Vérifier s'il existe un étudiant avec un ID spécifié dans l'URL
if (isset($_GET['id'])) {
    $etudiantId = $_GET['id'];
    $existingEtudiant = Etudiant::getEtudiantById($pdo, $etudiantId);
    
    // Obtenir les identifiants des promotions actuelles de l'étudiant
    $currentPromotionIds = EtudiantPromotion::getPromotionForEtudiant($pdo, $etudiantId);
};

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div hidden class="mb-2">
                    <label for="id" class="form-label">ID :</label>
                    <input type="text" class="form-control" name="id" value="<?php echo $existingEtudiant !== null ? $existingEtudiant->getId() : ''; ?>" required readonly>
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
                    <label for="date_naissance" class="form-label">Date de naissance :</label>
                    <input type="date" min="1980-01-01" max="<?php echo date('Y-m-d')?>" class="form-control" name="date_naissance" value="<?php echo $date_naissance; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="num_etudiant" class="form-label">Numéro étudiant :</label>
                    <input type="text" maxlength="8" pattern="[0-9]{8}" min="10000000" max="99999999" class="form-control" name="num_etudiant" value="<?php echo $num_etudiant; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="promotions" class="form-label">Promotion(s) :</label>
                    <?php foreach ($promotions as $promotion) : ?>
                <div class="form-control">
                    <input type="checkbox" name="promotions[]" value="<?php echo $promotion->getId(); ?>"<?php echo in_array($promotion->getId(), $currentPromotionIds ?? []) ? 'checked' : ''; ?>>
                    <label><?php echo $promotion->getAnnee(); ?></label>
                </div>
                    <?php endforeach; ?>
                <!-- </div>
                    <select class="form-control" name="promo" multiple required>
                        <?php
                                // Marquer comme sélectionné la promotion actuelle de l'étudiant
                                // $selected = ($existingEtudiant !== null && $existingEtudiant->getPromotionId() == $promotion->getId()) ? 'selected' : '';
                                // echo '<option value="' . $promotion->getId() . '" ' . $selected . '>' . $promotion->getAnnee() . '</option>';
                            
                        ?>
                    </select>
                </div> -->
 
                <button type="submit" class="btn btn-primary">
                    <?php echo $type === 'creer' ? 'Créer' : 'Modifier'; ?>
                </button>
        <a href="etudiants_list.php" class="btn btn-primary">Retour</a>
            </form>
        </div>
    </div>
</div>
