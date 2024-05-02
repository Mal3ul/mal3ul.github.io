<?php
class Module {
    private $id; 
    private $nom;
    private $duree;
    private $formationIds;  // Utilise un tableau pour stocker les IDs des formations
    // private $session = [];

    public function __construct($id, $nom, $duree, $formationIds) {

        $this->id = $id;
        $this->nom = $nom;
        $this->duree = $duree;

        $this->formationIds = $formationIds;
    }

    public function getId(){
        return $this->id;
    }
    public static function getModuleByIds($pdo, $id)
    {
        $sql = "SELECT * FROM modules WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Module($row['id'], $row['nom'], $row['duree'], $row['formation_id']);
    }

    public function getDuree(){
        return $this->duree;
    }

    public function getNom(){
        return $this->nom;
    }

    public static function delete($pdo, $id)
{
    $sql = "DELETE FROM modules WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => htmlspecialchars($id)]);

    // Supprime les associations avec les formations
    ModuleFormation::deleteModuleFormations($pdo, $id);

    return true;
}
    public static function creer($pdo, $nom, $duree, $formation){
    //$pdo, $_POST['module_name'], $_POST['module_duree'], $_POST['formation_id']
    try {
        // Insérer le nouveau module dans la table modules
        $sql = "INSERT INTO modules (nom, duree) VALUES (:nom, :duree)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => htmlspecialchars($nom),
            ':duree' => htmlspecialchars($duree),
        ]);

        // Récupérer l'ID du module nouvellement inséré
        $moduleId = $pdo->lastInsertId();

        // Insérer une ligne correspondante dans la table ModuleFormation
        $sql = "INSERT INTO module_formation (module_id, formation_id) VALUES (:module_id, :formation_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':module_id' => $moduleId,
            ':formation_id' => htmlspecialchars($formation[0]),
        ]);

        return true; // Succès
    } catch (PDOException $e) {
        // Gérer les erreurs
        error_log("Erreur lors de la création du module: " . $e->getMessage());
        return false; // Échec
    }   
    }

    public function update($pdo, $nom, $duree, $formationIds)
    {
        try {
            $sql = "UPDATE modules SET nom = :nom, duree = :duree WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':duree', $duree);
            $stmt->execute();

            // Met à jour les formations associées
            ModuleFormation::updateModuleFormations($pdo, $this->id, $formationIds);

            return true; // Update successful
        } catch (PDOException $e) {
            // Log or handle the error appropriately
            // For example, you can log the error to a file or output it for debugging
            error_log("Error updating module: " . $e->getMessage());
            return false; // Update failed
        }
    }

    public static function renderForm($type,  $existingModule = null)
    {

        $nom = $existingModule !== null ? $existingModule->getNom() : '';
        $duree = $existingModule !== null ? $existingModule->getduree() : '';

    
        return include '../Modules/form.php';
    }

    public function getFormationIds() {
        return $this->formationIds;
    }

    // Retourne un tableau d'abreviations de formations associées
    public function getFormations($pdo) {
        $formationAbrvs = [];

        foreach ($this->formationIds as $formationId) {
            $sql = "SELECT abreviation FROM formations WHERE id = :formation_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':formation_id' => $formationId]);

            $formationAbrv = $stmt->fetch(PDO::FETCH_COLUMN);
            if ($formationAbrv) {
                $formationAbrvs[] = $formationAbrv;
            }
        }

        return implode(', ', $formationAbrvs);
    }
    public static function getModuleByFormation($pdo, $formationId) {
        $sql = "SELECT * FROM modules WHERE formation_id = :formation_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':formation_id' => $formationId]);
    
        $modules = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $modules[] = new Module(
                $row['id'],
                htmlspecialchars($row['nom']),
                htmlspecialchars($row['duree']),
                $row['formation_id']
            );
        }
    
        return $modules;
    }

    public static function getAll($pdo) {

        $sql = "SELECT * FROM modules";
        $stmt = $pdo->query($sql);

        $modules = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $formationIds = ModuleFormation::getFormationForModule($pdo, $row['id']);
            $modules[] = new Module(
                $row['id'],
                htmlspecialchars($row['nom']),
                htmlspecialchars($row['duree']),
                $formationIds

            );
        }

        return $modules;
    }

}
?>