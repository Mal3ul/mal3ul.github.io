<?php
include 'datas.php';
include 'config.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=Formatech;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $errors = false;

    foreach ($formations as $formation) {
        if (!isset($formation['nom']) || !isset($formation['duree']) || !isset($formation['abreviation'])) {
            $errors = true;
            continue;
        }

        $sql = "INSERT INTO formations (name, duree, abreviation, RNCP_niveau, is_public) VALUES (:name, :duree, :abreviation, :niveau, :is_public)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $formation['nom'],
            ':duree' => $formation['duree'],
            ':abreviation' => $formation['abreviation'],
            ':niveau' => $formation['niveau'],
            ':is_public' => true,
        ]);

        // Create associated modules for the formation
    }

    echo $errors ? "Une erreur est survenue." : "Data inserted successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>



