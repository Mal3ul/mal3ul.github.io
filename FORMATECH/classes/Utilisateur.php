<?php

class Utilisateur
{
    private $id;
    private $nom;
    private $motDePasse;
    private $profil;

    public function __construct($id, $nom, $motDePasse, $profil)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->motDePasse = $motDePasse;
        $this->profil = $profil;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function getProfil()
    {
        return $this->profil;
    }

    // Méthode statique pour obtenir un utilisateur par son nom depuis la base de données
    public static function getUtilisateurByNom($pdo, $nom)
    {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom = :nom");
        $stmt->execute(['nom' => $nom]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return new Utilisateur($user['id'], $user['nom'], $user['mdp'], $user['profil']);
        }

        return null;
    }
}
?>
