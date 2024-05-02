<?php

class PromotionFormation {

    public static function getFormationForPromotion($pdo, $promotionId) {
        $sql = "SELECT formation_id FROM promotion_formation WHERE promotion_id = :promotion_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':promotion_id' => $promotionId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getPromotionForFormation($pdo, $formationId) {
        $sql = "SELECT promotion_id FROM promotion_formation WHERE formation_id = :formation_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':formation_id' => $formationId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function addPromotionFormation($pdo, $promotionId, $formationId) {
        $sql = "INSERT INTO promotion_formation (promotion_id, formation_id) VALUES (:promotion_id, :formation_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':promotion_id' => $promotionId, ':formation_id' => $formationId]);
    }

    public static function updatePromotionFormations($pdo, $promotionId, $formationIds) {
        try {
            $pdo->beginTransaction();
            
            self::deletePromotionFormations($pdo, $promotionId);
            foreach ($formationIds as $formationId) {
                self::addPromotionFormation($pdo, $promotionId, $formationId);
            }
        
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Erreur lors de la mise à jour des promotions et formations : " . $e->getMessage());
            // Gérer l'erreur
        }
        
    }

    public static function deletePromotionFormations($pdo, $promotionId) {
        $sql = "DELETE FROM promotion_formation WHERE promotion_id = :promotion_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':promotion_id' => $promotionId]);
    }
}

?>
