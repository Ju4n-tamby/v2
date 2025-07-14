<?php
require("../inc/function.php");

if (!isset($_SESSION["id"])) {
  header('Location: login.php');
  exit();
}

$membre = getMembreParId($_SESSION["id"]);
if (!$membre) {
  header('Location: login.php');
  exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['filtre']) || isset($_POST['nom_objet_recherche']))) {
  $id_categorie = $_POST['filtre'];
  $nom = $_POST['nom_objet_recherche'];
  $listeObjets = getObjetsParCategories($id_categorie, $nom);
} else {
  $listeObjets = getAllObjets();
}
if (isset($_POST['nombre_jours'])) {
  $nombre_jours = $_POST['nombre_jours'];
  $date = dateRetour($nombre_jours);
  emprunter($id_objet, $id_membre, $nombre_jours);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Objets</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body class="bg-light">

  <?php include('../inc/header.php') ?>

  <nav class="container rounded shadow-sm" style="background: linear-gradient(90deg, #e0ffe0 0%, #f0fff0 100%);">
    <h1 class="fw-bold fs-2 text-dark">Ajouter un nouvel element : </h1>

    <form action="../traitement/upload_objet.php" method="post" enctype="multipart/form-data" class="row g-2 align-items-center mb-4">
      <div class="col-md-3">
        <input type="text" name="nom_objet" class="form-control border-dark" placeholder="Nom de l'objet" required>
      </div>
      <div class="col-md-3">
        <select name="id_categorie" class="form-select border-dark" required>
          <option value="">Catégorie</option>
          <?php
          $categories = getAllCategories();
          foreach ($categories as $categorie) {
            echo '<option value="' . $categorie['id_categorie'] . '">' . $categorie['nom_categorie'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-md-3">
        <input type="file" name="image[]" class="form-control border-dark" accept="image/*" multiple>
        <span class="text-muted">Vous pouvez sélectionner plusieurs images</span>
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-dark">
          <i class="bi bi-plus-circle"></i> Ajouter
        </button>
      </div>
    </form>

  </nav>

  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-sm mb-4" style="background: linear-gradient(90deg, #f8f9fa 0%, #e0ffe0 100%);">
          <div class="card-body">
            <h2 class="card-title mb-4 text-dark"><i class="bi bi-list-ul"></i> Liste des Objets</h2>

            <form action="" method="post" class="row g-2 align-items-center mb-4">
              <div class="col-auto">
                <select name="filtre" class="form-select border-dark">
                  <option value="">Catégorie</option>
                  <?php
                  $categories = getAllCategories();
                  foreach ($categories as $categorie) { ?>
                    <option value="<?php echo $categorie['id_categorie']; ?>"><?php echo $categorie['nom_categorie']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-auto">
                <input type="text" name="nom_objet_recherche" class="form-control border-dark" placeholder="Nom de l'objet">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-dark">
                  <i class="bi bi-funnel"></i> Rechercher
                </button>
              </div>
            </form>

            <section class="d-flex flex-wrap gap-3 justify-content-center">
              <?php foreach ($listeObjets as $objet) { ?>

                <a href="fiche_objet.php?id_objet=<?php echo $objet['id_objet']; ?>" class="bg-white rounded shadow-sm p-3 flex-grow-1 link link-unstyled" style="min-width:250px; max-width:350px;text-decoration: none;">
                  <article class="element" style="min-width:250px; max-width:350px;">

                    <figure class="bg-dark container-fluid shadow-lg d-flex align-items-center justify-content-center" style="height: 220px; border-radius: 10px;">
                      <?php
                      $images = getImage($objet['id_objet']);
                      if (!empty($images)) {
                        $firstImage = $images[0]['nom_image'];
                        echo '<img src="' . getCheminImage($firstImage) . '" alt="Image" class="img-fluid w-100" style="object-fit: cover; height: 100%; border-radius: 10px;">';
                      } else {
                        echo '<i class="bi bi-box-seam text-danger" style="font-size: 2.5rem;"></i>';
                      }
                      ?>
                    </figure>

                    <h5 class="text-dark mb-2 text-truncate"><?php echo htmlspecialchars($objet['nom_objet']); ?></h5>
                    <p class="mb-1"><strong style="color:#198754;">Catégorie :</strong> <span style="color:#0d6efd;"><?php echo htmlspecialchars($objet['nom_categorie']); ?></span></p>
                    <p class="mb-1"><strong style="color:#198754;">Propriétaire :</strong> <span style="color:#fd7e14;"><?php echo htmlspecialchars($objet['nom']); ?></span></p>
                    <p class="mb-0">
                      <strong style="color:#198754;">Date retour :</strong>
                      <?php
                      $emprunt = verifier_emprunt_en_cours($objet['id_objet']);
                      if ($emprunt) {
                        if ($emprunt['date_retour'] === null) {
                          echo '<span class="text-warning">Inconnu</span>';
                        } else {
                          echo '<span class="text-danger fw-bold">' . htmlspecialchars($emprunt['date_retour']) . '</span>';
                        }
                      } else {
                        echo '<span class="text-muted">Aucun emprunt en cours</span>';
                      }
                      ?>
                    </p>
                    <form action="../traitement/traitement_emprunt.php" method="get" class="mt-2">
                      <input type="hidden" name="id_objet" value="<?php echo $objet['id_objet']; ?>">
                      <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-box-arrow-in-right"></i> Emprunter
                      </button>
                    </form>
                  </article>
                </a>
              <?php } ?>
              <?php if (empty($listeObjets)) { ?>
                <div class="bg-white rounded shadow-sm p-3 text-center text-muted w-100" style="border: 2px dashed #198754;">
                  Aucun objet trouvé.
                </div>
              <?php } ?>
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('../inc/footer.php') ?>

</body>

</html>
