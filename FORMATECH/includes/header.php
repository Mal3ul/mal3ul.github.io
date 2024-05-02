<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title><?php echo $titre ?></title> <!-- changement du titre de la page selon $titre -->
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand ml-auto mr-6" href="../index.php"><img src="../imgs/logo.png" alt="" style="width: 100px; height: 100px;"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto mr-6">
      <li class="nav-item <?php echo ($currentPage == 'Formation_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Formations/Formation_list.php">Formations<span class="sr-only">(current)</span></a>
      </li>
      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item <?php echo ($currentPage == 'Module_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Modules/Module_list.php">Modules</a>
      </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item <?php echo ($currentPage == 'Promotions_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Promotions/Promotions_list.php">Promotions</a>
      </li>
      <?php endif; ?>
      <?php if ((isset($_SESSION['profil'])) && ($_SESSION['profil'] === 'admin')) : ?>
      <li class="nav-item <?php echo ($currentPage == 'employes_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Employes/employes_list.php">Employés</a>
      </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item <?php echo ($currentPage == 'etudiants_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Etudiants/etudiants_list.php">Etudiants</a>
      </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item <?php echo ($currentPage == 'intervenants_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Intervenants/intervenants_list.php">Intervenants</a>
      </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item <?php echo ($currentPage == 'sessions_list.php') ? 'active' : ''; ?> mr-4">
        <a class="nav-link" href="../Sessions/sessions_list.php">Sessions</a>
      </li>
      <?php endif; ?>

      <?php if (isset($_SESSION['profil'])) : ?>
      <li class="nav-item mr-4">
          <a class="nav-link" href="../Connexion/deconnexion.php">Déconnexion</a>
      </li>
      <?php else : ?>
      <li class="nav-item mr-4">
          <a class="nav-link" href="../Connexion/connexion.php">Connexion</a>
      </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<?php
require_once '../Autoloader.php'; //Autoload
Autoloader::register();

$pdo = Database::getPDO();

?>