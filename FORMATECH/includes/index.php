<?php

$titre ="Page d'accueil";
include 'header.php';


?>

<div class="container mt-4">
  <div class="row">
    <div class="container mt-4">
      <div class="row">
        <?php
        $images = ['../imgs/energie_01.png', '../imgs/energie_02.png', '../imgs/energie_03.png', '../imgs/etudiants_01.png', '../imgs/etudiants_02.png', '../imgs/fusee_01.png', '../imgs/quantic_computers_01.png', '../imgs/robots_01.png', '../imgs/robots_02.png', '../imgs/VR_01.png', '../imgs/VR_02.png'];
        //$titles = ['Technicien en maintenance robotique', 'Bachelor administrateur en technologies novatrices','Ingénieur expert en fusion cybernétique'];
        
        foreach ($images as $image) {
          
          echo '<div class="col-md-4 mb-4">';
          echo '<img src="' . $image . '" alt="' . $image . '" class="img-fluid">';
          echo '<h3 class="mt-3"> Titre de la formation </h3>';
          echo '<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet</p>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>