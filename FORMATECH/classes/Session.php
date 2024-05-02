<?php
class Session {
    private $id;
    private $date;
    private $heure_debut;
    private $heure_fin;
    private $modules;
    private $promos;
    private $intervenants;
    //private $salle=[];
    
    public function __construct($id, $date, $heure_debut, $heure_fin, $modules, $promos, $intervenants){
        $this->id = $id;
        $this->date = $date;
        $this->heure_debut = $heure_debut;
        $this->heure_fin = $heure_fin;
        $this->modules = $modules;
        $this->promos = $promos;
        $this->intervenants = $intervenants;
    }

    public function getId(){
        return $this->id;
    }
    public function getDate(){
        return $this->date;
    }
    public function getDebut(){
        return $this->heure_debut;
    }
    public function getFin(){
        return $this->heure_fin;
    }
    public function getModules(){
        return $this->modules;
    }
    public function getPromos(){
        return $this->promos;
    }
    public function getIntervenants(){
        return $this->intervenants;
    }
    public static function getAll($pdo)
    {
        $sql = "SELECT * FROM sessions";
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            die("Erreur d'exécution de la requête SQL");
        }
        $sessions = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $session = new Session(
                $row['id'],
                htmlspecialchars($row['date']),
                htmlspecialchars($row['heure_debut']),
                htmlspecialchars($row['heure_fin']),
                htmlspecialchars($row['modules']),
                htmlspecialchars($row['promos']),
                htmlspecialchars($row['intervenants']),
            );
            $sessions[] = $session;
        }
        return $sessions;
    }
    public static function getSessionById($pdo, $id)
    {
        $sql = "SELECT * FROM sessions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Session($row['id'], $row['date'], $row['heure_debut'], $row['heure_fin'], $row['modules'], $row['promos'], $row['intervenants']);
    }
    public function update($pdo, $date, $heure_debut, $heure_fin, $modules, $promos, $intervenants){
        try {
            $sql = "UPDATE sessions SET date = :date, heure_debut = :heure_debut, heure_fin = :heure_fin, modules = :modules, promos = :promos, intervenants = :intervenants WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id,
                ':date' => $date,
                ':heure_debut' => $heure_debut,
                ':heure_fin' => $heure_fin,
                ':modules' => $modules,
                ':promos' => $promos,
                ':intervenants' => $intervenants
            ]);

            return true; 
        } catch (PDOException $e) {
            error_log("Error updating session: " . $e->getMessage());
            return false; 
        }
    }

    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM sessions WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => htmlspecialchars($id)]);
    }
    public static function creer($pdo, $date, $heure_debut, $heure_fin, $modules, $promos, $intervenants)
    {
        $sql = "INSERT INTO sessions (date, heure_debut, heure_fin, modules, promos, intervenants) VALUES ( :date, :heure_debut, :heure_fin, :modules, :promos, :intervenants)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':date' => htmlspecialchars($date),
            ':heure_debut' => htmlspecialchars($heure_debut),
            ':heure_fin' => htmlspecialchars($heure_fin),
            ':modules' => htmlspecialchars($modules),
            ':promos' => htmlspecialchars($promos),
            ':intervenants' => htmlspecialchars($intervenants)
        ]);
    }
    public static function renderForm($type,  $existingSession = null)
    {
        $date = $existingSession !== null ? $existingSession->getDate() : '';
        $heure_debut = $existingSession !== null ? $existingSession->getDebut() : '';
        $heure_fin = $existingSession !== null ? $existingSession->getFin() : '';
        $modules = $existingSession !== null ? $existingSession->getModules() : '';
        $promos = $existingSession !== null ? $existingSession->getPromos() : '';
        $intervenants = $existingSession !== null ? $existingSession->getIntervenants() : '';
    
        return include '../Sessions/form.php';
    }
}
?>