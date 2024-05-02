<?php

class Promotion {
    private $id;
    private $annee;
    private $date_debut;
    private $date_fin;
    private $formationId;
    // private $etudiants=[];
    
    public function __construct($id, $annee, $date_debut, $date_fin, $formationId) {
        $this->id = $id;
        $this->annee = $annee;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->formationId = $formationId;
    }

    public static function getAll($pdo) {
        $sql = "SELECT * FROM promotions";
        $stmt = $pdo->query($sql);

        $promotions = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $promotion = new Promotion(
                $row['id'],
                $row['annee'],
                $row['date_debut'],
                $row['date_fin'],
                $row['formationId']
            );
            $promotions[] = $promotion;
        }

        return $promotions;
    }

    public function getId() {
        return $this->id;
    }

    
    public function getAnnee() {
        return $this->annee;
    }
    
    public function getDateDebut() {
        return $this->date_debut;
    }
    
    public function getDateFin() {
        return $this->date_fin;
    }
    public function getFormationId() {
        return $this->formationId;
    }

    public function getFormationIds($pdo) {
        return PromotionFormation::getFormationForPromotion($pdo, $this->id);
    }
    public function getFormations($pdo) {
        $formationIds = $this->getFormationIds($pdo);
        $abrevs = [];

        foreach ($formationIds as $formationId) {
            $sql = "SELECT abreviation FROM formations WHERE id = :formation_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':formation_id' => $formationId]);

            $abrev = $stmt->fetch(PDO::FETCH_COLUMN);
            if ($abrev) {
                $abrevs[] = $abrev;
            }
        }

        return $abrevs;
    }
    
    public static function creer($pdo, $annee, $date_debut, $date_fin, $formationId) {
        try {
        $sql = "INSERT INTO promotions (annee, date_debut, date_fin, formationId) VALUES (:annee, :date_debut, :date_fin, :formationId)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':annee' => htmlspecialchars($annee),
            ':date_debut' => htmlspecialchars($date_debut),
            ':date_fin' => htmlspecialchars($date_fin),
            ':formationId' => htmlspecialchars($formationId[0]),
        ]);
        // Récupérer l'ID de la promotion nouvellement inséré
        $promotionId = $pdo->lastInsertId();

        // Insérer une ligne correspondante dans la table PromotionFormation
        $sql = "INSERT INTO promotion_formation (promotion_id, formation_id) VALUES (:promotion_id, :formation_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':promotion_id' => $promotionId,
            ':formation_id' =>$formationId[0],
        ]);

        return true; // Succès
    } catch (PDOException $e) {
        // Gérer les erreurs
        error_log("Erreur lors de la création du module: " . $e->getMessage());
        return false; // Échec
    }   
    }
    

    public static function delete($pdo, $id) {
        $sql = "DELETE FROM promotions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }

    public static function getPromotionById($pdo, $id) 
    {
        $sql = "SELECT * FROM promotions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Promotion($row['id'], $row['annee'], $row['date_debut'], $row['date_fin'], $row['formationId']);
    }

    public function update($pdo, $annee, $date_debut, $date_fin, $formationIds) {
        try {
            $sql = "UPDATE promotions SET annee = :annee, date_debut = :date_debut, date_fin = :date_fin WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':annee', $annee);
            $stmt->bindParam(':date_debut', $date_debut);
            $stmt->bindParam(':date_fin', $date_fin);
            $stmt->execute();
    
            // Mise à jour des formations associées
            PromotionFormation::updatePromotionFormations($pdo, $this->id, $formationIds);
    
            return true; // Mise à jour réussie
        } catch (PDOException $e) {
            // Gérer l'erreur de mise à jour
            error_log("Erreur lors de la mise à jour de la promotion: " . $e->getMessage());
            return false; // Mise à jour échouée
        }
    }
    
    

    public static function renderForm($type, $existingPromotion = null)
    {
        $formationId = $existingPromotion !== null ? $existingPromotion->getFormationId() : '';
        $annee = $existingPromotion !== null ? $existingPromotion->getAnnee() : '';
        $date_debut = $existingPromotion !== null ? $existingPromotion->getDateDebut() : '';
        $date_fin = $existingPromotion !== null ? $existingPromotion->getDateFin() : '';
    
        return include '../Promotions/form.php';
    }
}
?>
