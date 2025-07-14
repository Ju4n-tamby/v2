<?php
$user = getMembreParId($_SESSION["id"]); ?>

<nav class="navbar navbar-expand-lg navbar-success bg-success mb-4">
  <div class="container-fluid">
    <a class="navbar-brand text-white fw-bold" href="#">Emprunt_V1</a>
    <div class="d-flex align-items-center">
      <span class="text-white me-3">
        <?= afficherImage($user['image']); ?>
        <a href="../pages//fiche_membre.php?id_membre=<?= $_SESSION["id"] ?>"><?php echo htmlspecialchars($user['nom']); ?></a>
      </span>
      <a class="btn btn-dark" href="../traitement/deconnexion.php">
        <i class="bi bi-box-arrow-right"></i> Déconnexion
      </a>
    </div>
  </div>
</nav>
