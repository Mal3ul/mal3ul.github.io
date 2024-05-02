<?php

include_once '../bdd/config.php';
// include_once 'classes/Database.php';

class Formation
{
    private $id;
    private $nom;
    private $duree;
    private $abreviation;
    private $niveau;
    private $is_public;
    private $moduleIds;
    

    public function __construct($id, $nom, $duree, $abreviation, $niveau, $is_public)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->duree = $duree;
        $this->abreviation = $abreviation;
        $this->niveau = $niveau;
        $this->is_public = $is_public;
        // On initialise le tableau des id de module à vide pour ajouter les modules par la suite
        
        
    }
    /**
     * Retourne les modules de la formation sous forme de chaine de caractères
     *
     * @param PDO $pdo
     * @return string
     */
    public function getModules($pdo) {
        $moduleNoms = [];

        foreach ($this->moduleIds as $moduleId) {
            $sql = "SELECT nom FROM modules WHERE id = :module_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':module_id' => $moduleId]);

            $moduleNom = $stmt->fetch(PDO::FETCH_COLUMN);
            if ($moduleNom) {
                $moduleNoms[] = $moduleNom;
            }
        }

        return implode(', ', $moduleNoms);
    }

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM formations";
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            die("Erreur d'exécution de la requête SQL");
        }
        $formations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Création de la formation
            $formation = new Formation(
                $row['id'],
                htmlspecialchars($row['nom']),
                htmlspecialchars($row['duree']),
                htmlspecialchars($row['abreviation']),
                htmlspecialchars($row['niveau']),
                htmlspecialchars($row['is_public']),
            );

            // On récupère les modules correspondant à la formation
            $moduleIds = ModuleFormation::getModuleForFormation($pdo, $formation->id);
            $formation->moduleIds = $moduleIds;

            // On l'ajoute au tableau de formations
            $formations[] = $formation;
        }

        return $formations;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getduree()
    {
        return $this->duree;
    }

    public function getAbreviation()
    {
        return $this->abreviation;
    }

    public function getNiveau()
    {
        return $this->niveau;
    }

    public function getis_public()
    {
        return $this->is_public;
    }
    public function getModuleIds(){
        return $this->moduleIds;
    }

    public static function creer($pdo, $nom, $duree, $abreviation, $niveau, $is_public)
    {
        $sql = "INSERT INTO formations (nom, duree, abreviation, niveau, is_public) VALUES (:nom, :duree, :abreviation, :niveau, :is_public)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => htmlspecialchars($nom),
            ':duree' => htmlspecialchars($duree),
            ':abreviation' => htmlspecialchars($abreviation),
            ':niveau' => htmlspecialchars($niveau),
            ':is_public' => htmlspecialchars($is_public)
        ]);
    }

    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM formations WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }
    

    public static function getFormationById($pdo, $id)
    {
        $sql = "SELECT * FROM formations WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Formation($row['id'], $row['nom'], $row['duree'], $row['abreviation'], $row['niveau'], $row['is_public']);
    }

    public function update($pdo, $nom, $duree, $abreviation, $niveau, $is_public)
    {
        try {
            $sql = "UPDATE formations SET nom = :nom, duree = :duree, abreviation = :abreviation, niveau = :niveau, is_public = :is_public WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':nom' => $nom,
                ':duree' => $duree,
                ':abreviation' => $abreviation,
                ':niveau' => $niveau,
                ':is_public' => $is_public
            ]);

            return true; // Update successful
        } catch (PDOException $e) {
            // Log or handle the error appropriately
            // For example, you can log the error to a file or output it for debugging
            error_log("Error updating formation: " . $e->getMessage());
            return false; // Update failed
        }
    }

    public static function renderForm($type,  $existingFormation = null)
    {
        $nom = $existingFormation !== null ? $existingFormation->getNom() : '';
        $duree = $existingFormation !== null ? $existingFormation->getduree() : '';
        $abreviation = $existingFormation !== null ? $existingFormation->getAbreviation() : '';
        $niveau = $existingFormation !== null ? $existingFormation->getNiveau() : '';
        $is_public = $existingFormation !== null ? $existingFormation->getis_public() : '';
    
        return include '../Formations/form.php';
    }
}