<?php
class Intervenant {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $session;
    public function __construct($id, $nom, $prenom, $email, $session) {
        $this->prenom = $prenom;
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->session=$session;
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
    public function getSession()
    {
        return $this->session;
    }

    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM intervenants";
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            die("Erreur d'exécution de la requête SQL");
        }
        $intervenants = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $intervenant = new Intervenant(
                $row['id'],
                htmlspecialchars($row['nom']),
                htmlspecialchars($row['prenom']),
                htmlspecialchars($row['email']),
                htmlspecialchars($row['session']),
            );
            $intervenants[] = $intervenant;
        }
        return $intervenants;
    }

    public static function getIntervenantById($pdo, $id)
    {
        $sql = "SELECT * FROM intervenants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Intervenant($row['id'], $row['nom'], $row['prenom'], $row['email'], $row['session']);
    }
    
    public function update($pdo, $nom, $prenom, $email, $session){
        try {
            $sql = "UPDATE intervenants SET nom = :nom, prenom = :prenom, email = :email, session = :session WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':email' => $email,
                ':session' => $session
            ]);

            return true; 
        } catch (PDOException $e) {
            error_log("Error updating Intervenant: " . $e->getMessage());
            return false; 
        }
    }

    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM intervenants WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }
    public static function creer($pdo, $prenom, $nom, $email, $session)
    {
        $sql = "INSERT INTO intervenants (prenom, nom, email, session) VALUES (:prenom, :nom, :email, :session)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':prenom' => htmlspecialchars($prenom),
            ':nom' => htmlspecialchars($nom),
            ':email' => htmlspecialchars($email),
            ':session' => htmlspecialchars($session)
        ]);
    }
    public static function renderForm($type,  $existingIntervenant = null)
    {
        $nom = $existingIntervenant !== null ? $existingIntervenant->getNom() : '';
        $prenom = $existingIntervenant !== null ? $existingIntervenant->getPrenom() : '';
        $email = $existingIntervenant !== null ? $existingIntervenant->getEmail() : '';
        $session = $existingIntervenant !== null ? $existingIntervenant->getSession() : '';
    
        return include '../Intervenants/form.php';
    }

    //Ajouter un intervenant à une session
    // public static function ajoutIntervenantASession($intervenant,$session){
    //     require_once('includes/connexion.inc.php');
    //     try{
    //         $sth = $dbh->prepare("INSERT INTO intervention(id_interven
    //         , id_sessio) VALUES(:i,:s)");
    //         $sth -> bindParam(':i',$intervenant);
    //         $sth -> bindParam(':s',$session);
    //         $sth -> execute();
    //         }catch (Exception $e){
    //             die('Erreur : ' . $e->getMessage());
    //             }
    //             }

}
?>