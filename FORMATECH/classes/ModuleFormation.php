<?php
class ModuleFormation {
    
    public static function getFormationForModule($pdo, $moduleId) {
        $sql = "SELECT formation_id FROM module_formation WHERE module_id = :module_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':module_id' => $moduleId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    public static function getModuleForFormation($pdo, $formationId) {
        $sql = "SELECT module_id FROM module_formation WHERE formation_id = :formation_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':formation_id' => $formationId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function addModuleFormation($pdo, $moduleId, $formationId)
    {
        $sql = "INSERT INTO module_formation (module_id, formation_id) VALUES (:module_id, :formation_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':module_id' => $moduleId, ':formation_id' => $formationId]);
    }
    
    public static function updateModuleFormations($pdo, $moduleId, $formationIds)
{
    if (!is_array($formationIds)) {
        echo "Ce n'est pas un tableau.";
        return;
    }

    // Supprime les anciennes associations
    self::deleteModuleFormations($pdo, $moduleId);

    // Ajoute les nouvelles associations
    foreach ($formationIds as $formationId) {
        self::addModuleFormation($pdo, $moduleId, $formationId);
    }
}

public static function deleteModuleFormations($pdo, $moduleId)
{
    $sql = "DELETE FROM module_formation WHERE module_id = :module_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':module_id' => $moduleId]);
}

}
?>