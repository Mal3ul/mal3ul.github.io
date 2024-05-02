<?php

require_once 'Autoloader.php';
Autoloader::register();
include './classes/database.php';


include 'bdd/datas.php';
Database::getPDO();

// Fonction pour échapper les apostrophes
function escapeApostrophe($string) {
    return mysqli_real_escape_string($GLOBALS['conn'], $string);
}

// Fonction pour insérer des données dans la table formations
function insertFormations($conn, $formations)
{
    foreach ($formations as $formation) {
        $nom = escapeApostrophe($formation['nom']);
        $abreviation = escapeApostrophe($formation['abreviation']);
        $duree = $formation['duree'];
        $niveau = $formation['niveau'];

        $sql = "INSERT INTO formations (name, duree, abreviation, RNCP_niveau) VALUES ('$nom', $duree, '$abreviation', $niveau)";

        if ($conn->query($sql) !== TRUE) {
            echo "Erreur lors de l'insertion dans la table formations : " . $conn->error;
        }
    }
}

// Fonction pour insérer des données dans la table modules
function insertModules($conn, $modules)
{
    foreach ($modules as $module) {
        $nom = escapeApostrophe($module['nom']);
        $duree = $module['duree'];
        $formation = $module['formation'];

        $sql = "INSERT INTO modules (nom, duree, formation_id) VALUES ('$nom', $duree, $formation)";

        if ($conn->query($sql) !== TRUE) {
            echo "Erreur lors de l'insertion dans la table modules : " . $conn->error;
        }
    }
}

// Fonction pour insérer des données dans la table salles
function insertSalles($conn, $salles)
{
    foreach ($salles as $salle) {
        $nom = $salle['nom'];
        $capacite = $salle['capacite'];
        $batiment = $salle['batiment'];

        $sql = "INSERT INTO salles (nom, capacite, batiment) VALUES ('$nom', $capacite, $batiment)";

        if ($conn->query($sql) !== TRUE) {
            echo "Erreur lors de l'insertion dans la table salles : " . $conn->error;
        }
    }
}

// Appeler les fonctions d'insertion
insertFormations($conn, $formations);
insertModules($conn, $modules);
insertSalles($conn, $salles);

// Fermer la connexion
$conn->close();

?>