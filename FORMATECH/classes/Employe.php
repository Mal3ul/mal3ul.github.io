<?php
class Employe {
    private $id;
    private $nom;
    private $prenom;
    private $poste;
    private $email;


    public function __construct($id, $nom, $prenom, $poste, $email) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->poste = $poste;
        $this->email = $email;
    }
    public function getId(){
        return $this->id;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getPoste(){
        return $this->poste;
    }
    public function getEmail(){
        return $this->email;
    }
    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM employes";
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            die("Erreur d'exécution de la requête SQL");
        }
        $employes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $employe = new Employe(
                $row['id'],
                htmlspecialchars($row['nom']),
                htmlspecialchars($row['prenom']),
                htmlspecialchars($row['poste']),
                htmlspecialchars($row['email'])
            );
            $employes[] = $employe;
        }
        return $employes;
    }

    public static function getEmployeById($pdo, $id)
    {
        $sql = "SELECT * FROM employes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Employe($row['id'], $row['nom'], $row['prenom'], $row['poste'], $row['email']);
    }
    
    public function update($pdo, $nom, $prenom, $poste, $email){
        try {
            $sql = "UPDATE employes SET nom = :nom, prenom = :prenom, poste = :poste, email = :email WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':poste' => $poste,
                ':email' => $email
            ]);

            return true; 
        } catch (PDOException $e) {
            error_log("Error updating employe: " . $e->getMessage());
            return false; 
        }
    }

    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM employes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }
    public static function creer($pdo, $nom, $prenom, $poste, $email)
    {
        $sql = "INSERT INTO employes (nom, prenom, poste, email) VALUES (:nom, :prenom, :poste, :email)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':nom' => htmlspecialchars($nom),
            ':prenom' => htmlspecialchars($prenom),
            ':email' => htmlspecialchars($email),
            ':poste' => htmlspecialchars($poste)
        ]);
    }
    public static function renderForm($type,  $existingEmploye = null)
    {
        $nom = $existingEmploye !== null ? $existingEmploye->getNom() : '';
        $prenom = $existingEmploye !== null ? $existingEmploye->getPrenom() : '';
        $poste = $existingEmploye !== null ? $existingEmploye->getPoste() : '';
        $email = $existingEmploye !== null ? $existingEmploye->getEmail() : '';
    
        return include '../Employes/form.php';
    }
}
?>