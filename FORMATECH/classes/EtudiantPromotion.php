<?php

class EtudiantPromotion {

    public static function getPromotionForEtudiant($pdo, $etudiantId) {
        $sql = "SELECT promotion_id FROM etudiant_promotion WHERE etudiant_id = :etudiant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':etudiant_id' => $etudiantId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function getEtudiantForPromotion($pdo, $promotionId) {
        $sql = "SELECT etudiant_id FROM etudiant_promotion WHERE promotion_id = :promotion_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':promotion_id' => $promotionId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function addEtudiantPromotion($pdo, $etudiantId, $promotionId) {
        $sql = "INSERT INTO etudiant_promotion (etudiant_id, promotion_id) VALUES (:etudiant_id, :promotion_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':etudiant_id' => $etudiantId, ':promotion_id' => $promotionId]);
    }

    public static function updateEtudiantPromotion($pdo, $etudiantId, $promotionIds) {

        if (!is_array($promotionIds)) {
            echo " ce n'est pas un array.";
            return;
        }
        // Supprime les anciennes associations
        self::deleteEtudiantPromotions($pdo, $etudiantId);

        // Ajoute les nouvelles associations
        foreach ($promotionIds as $promotionId) {
            self::addEtudiantPromotion($pdo, $etudiantId, $promotionId);
        }
    }

    public static function deleteEtudiantPromotions($pdo, $etudiantId) {
        $sql = "DELETE FROM etudiant_promotion WHERE etudiant_id = :etudiant_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':etudiant_id' => $etudiantId]);
    }
}

?>
