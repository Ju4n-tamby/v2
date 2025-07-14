<?php
require("../inc/function.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body class="bg-dark">
  <section class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5 col-lg-4 border rounded-4 shadow-lg p-5 bg-light">
      <h2 class="mb-4 text-center text-danger"><i class="bi bi-person-plus"></i> Inscription</h2>
      <form action="../traitement/inscription_traitement.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nom" class="form-label">Nom</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="date_naissance" class="form-label">Date de naissance</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="genre" class="form-label">Genre</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
            <select class="form-select" id="genre" name="genre" required>
              <option value="" disabled selected>Choisissez votre genre</option>
              <option value="M">Masculin</option>
              <option value="F">Féminin</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label for="ville" class="form-label">Ville</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
            <input type="text" class="form-control" id="ville" name="ville" placeholder="Entrez votre ville" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="mail" class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="mail" name="mail" placeholder="Entrez votre email" required>
          </div>
        </div>
        <div class="mb-4">
          <label for="mdp" class="form-label">Mot de passe</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe" required>
          </div>
        </div>
        <div class="mb-4">
          <label for="image" class="form-label">Photo de profil</label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-danger w-100 mb-2">S'inscrire</button>
      </form>
      <div class="text-center mt-3">
        <a href="login.php" class="link-danger text-decoration-none">Déjà inscrit ? Se connecter</a>
      </div>
    </div>
  </section>

  <footer class="navbar w-100">
    <div class="container text-center d-flex flex-column align-items-center">
      <ul class="d-flex justify-content-center gap-4 list-unstyled">
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">A propos</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Confidentialité</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Services</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Aide</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Conditions</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Contact</a></li>
        <li><a class="fw-ligh link-light link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover" href="#">Envoyer des commentaires</a></li>
      </ul>
      <p class="text-light">&copy; 2025 Emprunt_V1. Tous droits réservés.</p>
    </div>
  </footer>
</body>

</html>
