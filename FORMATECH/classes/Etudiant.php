<?php
class Etudiant {
    private $id;
    private $prenom;
    private $nom;
    private $email;
    private $date_naissance;
    private $num_etudiant;
    private $promo;

    public function __construct($id, $prenom, $nom, $email, $date, $numEtud, $promo) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->date_naissance = $date;
        $this->num_etudiant = $numEtud;
        $this->promo = $promo;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getPrenom()
    {
        return $this->prenom;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }
    public function getNum()
    {
        return $this->num_etudiant;
    }
     public function getPromotionId()
    {
        return $this->promo; // Retourne l'ID de la promotion à laquelle l'étudiant est associé
    }

    public function setPromotionId($promoId)
    {
        $this->promo = $promoId; // Définit l'ID de la promotion à laquelle l'étudiant est associé
    }
    // public function getModules($pdo) {
    //     $moduleNoms = [];

    //     foreach ($this->moduleIds as $moduleId) {
    //         $sql = "SELECT nom FROM modules WHERE id = :module_id";
    //         $stmt = $pdo->prepare($sql);
    //         $stmt->execute([':module_id' => $moduleId]);

    //         $moduleNom = $stmt->fetch(PDO::FETCH_COLUMN);
    //         if ($moduleNom) {
    //             $moduleNoms[] = $moduleNom;
    //         }
    //     }

    //     return implode(', ', $moduleNoms);
    // }

    public static function getAll($pdo)
{
    $sql = "SELECT e.*, GROUP_CONCAT(p.annee SEPARATOR ', ') AS promotions
            FROM etudiants e
            LEFT JOIN etudiant_promotion ep ON e.id = ep.etudiant_id
            LEFT JOIN promotions p ON ep.promotion_id = p.id
            GROUP BY e.id";
    $stmt = $pdo->query($sql);

    $etudiants = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $etudiants[] = new Etudiant(
            $row['id'],
            htmlspecialchars($row['prenom']),
            htmlspecialchars($row['nom']),
            htmlspecialchars($row['email']),
            htmlspecialchars($row['date_naissance']),
            htmlspecialchars($row['num_etudiant']),
            htmlspecialchars($row['promotions']) // Maintenant, 'promotions' contient les années au lieu des IDs
        );
    }

    return $etudiants;
}


    public static function getEtudiantById($pdo, $id)
    {
        $sql = "SELECT * FROM etudiants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Etudiant($row['id'], $row['nom'], $row['prenom'], $row['email'], $row['date_naissance'], $row['num_etudiant'], $row['promo']);
    }

    public function update($pdo, $nom, $prenom, $email, $date_naissance, $num_etudiant)
    {
        try {
            $sql = "UPDATE etudiants SET nom = :nom, prenom = :prenom, email = :email, date_naissance = :date_naissance, num_etudiant = :num_etudiant WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':date_naissance' => $date_naissance,
                ':num_etudiant' => $num_etudiant
            ]);

            return true;
        } catch (PDOException $e) {
            error_log("Error updating Etudiant: " . $e->getMessage());
            return false;
        }
    }
    public static function renderForm($type,  $existingEtudiant = null, $promotions = [])
    {
        $nom = $existingEtudiant !== null ? $existingEtudiant->getNom() : '';
        $prenom = $existingEtudiant !== null ? $existingEtudiant->getPrenom() : '';
        $email = $existingEtudiant !== null ? $existingEtudiant->getEmail() : '';
        $date_naissance = $existingEtudiant !== null ? $existingEtudiant->getDateNaissance() : '';
        $num_etudiant = $existingEtudiant !== null ? $existingEtudiant->getNum() : '';
        $promotionId = $existingEtudiant !== null ? $existingEtudiant->getPromotionId() : '';
    
        return include '../Etudiants/form.php';
    }
    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM etudiants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }
    public static function creer($pdo, $prenom, $nom, $email, $date_naissance, $num_etudiant, $promotions) {
        try {
            // Commencez par exécuter une seule fois la requête pour créer l'étudiant
            $sql = "INSERT INTO etudiants (prenom, nom, email, date_naissance, num_etudiant) VALUES (:prenom, :nom, :email, :date_naissance, :num_etudiant)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':prenom' => htmlspecialchars($prenom),
                ':nom' => htmlspecialchars($nom),
                ':email' => htmlspecialchars($email),
                ':date_naissance' => htmlspecialchars($date_naissance),
                ':num_etudiant' => htmlspecialchars($num_etudiant),
            ]);
    
            // Récupérez l'ID de l'étudiant nouvellement créé
            $etudiantId = $pdo->lastInsertId();
    
            // Ensuite, insérez les associations avec les promotions sélectionnées
            $sql = "INSERT INTO etudiant_promotion (etudiant_id, promotion_id) VALUES (:etudiant_id, :promotion_id)";
            $stmt = $pdo->prepare($sql);
    
            // Pour chaque promotion sélectionnée, exécutez la requête pour créer une association avec l'étudiant
            foreach ($promotions as $promoId) {
                $stmt->execute([
                    ':etudiant_id' => $etudiantId,
                    ':promotion_id' => $promoId,
                ]);
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error creating Etudiant: " . $e->getMessage());
            return false;
        }
    }
    
    
    // public function afficherInformationsPersonnelles()
    // {
    //     echo "Informations personnelles de l'étudiant :";
    //     echo "\nNom: {$this->nom}";
    //     echo "\nPrenom: {$this->prenom}";
    //     echo "\nEmail: {$this->mail}";
    //     echo "\nDate de naissance: {$this->date_naissance}";
    //     echo "\nNuméro étudiant: {$this->num_etudiant}";
    //     echo "\nPromo : {$this->promo}";
    // }
}
?>