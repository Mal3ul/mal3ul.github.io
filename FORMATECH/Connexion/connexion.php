<?php
session_start();
$titre = "Connexion";
include '../includes/header.php';

$pdo = Database::getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Recherche de l'utilisateur par son nom
    $utilisateur = Utilisateur::getUtilisateurByNom($pdo, $nom);

    if ($utilisateur && $password === $utilisateur->getMotDePasse()) {
        $_SESSION['profil'] = $utilisateur->getProfil();
        
        if ($_SESSION['profil'] === 'admin') {
            header('Location: ../index.php');
            exit();
        } elseif ($_SESSION['profil'] === 'gest') {
            header('Location: ../index.php');
            exit();
        } else {
            $message = 'Profil non reconnu.';
        }
    } else {
        // Nom ou mot de passe incorrect
        $message = 'Nom ou mot de passe incorrect.';
    }
}
?>





<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="mb-4">Connexion</h2>
            <?php if (isset($message)) : ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
        </div>
    </div>
</div>


<?php include '../includes/footer.php'; ?>