<?php
require("../inc/function.php");
if (isset($_GET['id_objet'])) {
  $id_objet = $_GET['id_objet'];
  $objet = getObjetParId($id_objet);
}
$historiqueEmprunt = getHistoriqueEmprunts($id_objet);
$proprietaire = getMembreParId($objet['id_membre']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fiche -- <?php echo $objet['nom_objet']; ?></title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body class="bg-light">

  <?php include('../inc/header.php'); ?>

  <a href="liste_objet.php" class="btn btn-secondary"> <- Retour </a>
      <div class="container py-4">
        <div class="card shadow-lg mb-4">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-lg-6">
                <h1 class="fw-bold text-dark mb-3"><?php echo $objet['nom_objet']; ?></h1>
                <p class="mb-2"><strong class="text-success">Catégorie :</strong> <span class="text-primary"><?php echo $objet['nom_categorie']; ?></span></p>
                <p class="mb-2 d-flex align-items-center gap-5">
                  <strong class="text-success">Propriétaire :</strong>
                  <a href="../pages/fiche_membre.php?id_membre=<?php echo $objet['id_membre']; ?>" class="text-decoration-none text-warning d-inline-flex align-items-center">
                    <?php echo afficherImage($proprietaire['image']); ?>
                    <span class="ms-2"><?php echo $proprietaire['nom']; ?></span>
                  </a>
                </p>
              </div>
              <div class="col-lg-6 text-center">
                <?php
                $images = getImage($objet['id_objet']);
                if (!empty($images)) {
                  $mainImage = $images[0]['nom_image'];
                  echo '<img src="' . getCheminImage($mainImage) . '" alt="Image principale" class="img-fluid rounded shadow" style="max-height:350px;object-fit:cover;">';
                } else {
                  echo '<div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 350px;"><i class="bi bi-box-seam text-white" style="font-size: 4rem;"></i></div>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="card shadow mb-4">
          <div class="card-body">
            <h2 class="card-title mb-3 text-dark"><i class="bi bi-images"></i> Galerie d'images</h2>
            <div class="row g-3">
              <?php
              foreach ($images as $image) {
                echo '<div class="col-6 col-md-4 col-lg-3 text-center">';
                echo '<div class="position-relative">';
                echo '<img src="' . getCheminImage($image['nom_image']) . '" alt="Image" class="img-fluid rounded border" style="max-height:150px;object-fit:cover;">';
                echo '<a href="../traitement/supprimer_image.php?id_image=' . $image['id_image'] . '&id_objet=' . $objet['id_objet'] . '" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1""><i class="bi bi-trash"></i></a>';
                echo '</div>';
                echo '</div>';
              }
              if (empty($images)) {
                echo '<div class="col-12 text-muted text-center">Aucune image disponible.</div>';
              }
              ?>
            </div>
          </div>
        </div>

        <div class="card shadow mb-4">
          <div class="card-body">
            <h2 class="card-title mb-3 text-dark"><i class="bi bi-clock-history"></i> Historique des emprunts</h2>
            <div class="table-responsive">
              <table class="table table-bordered align-middle">
                <thead class="table-success">
                  <tr>
                    <th>Emprunteur</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (!empty($historiqueEmprunt)) {
                    foreach ($historiqueEmprunt as $emprunt) {
                      $emprunteur = getMembreParId($emprunt['id_membre']);
                      echo '<tr>';
                      echo '<td>';
                      echo '<a href="../pages/fiche_membre.php?id_membre=' . $emprunteur['id_membre'] . '" class="d-inline-flex align-items-center text-decoration-none">';
                      echo afficherImage($emprunteur['image']);
                      echo '<span class="ms-2">' . htmlspecialchars($emprunteur['nom']) . '</span>';
                      echo '</a>';
                      echo '</td>';
                      echo '<td>' . htmlspecialchars($emprunt['date_emprunt']) . '</td>';
                      echo '<td>' . (!empty($emprunt['date_retour']) ? htmlspecialchars($emprunt['date_retour']) : '<span class="text-danger">Non retourné</span>') . '</td>';
                      echo '</tr>';
                    }
                  } else {
                    echo '<tr><td colspan="3" class="text-center text-muted">Aucun emprunt enregistré.</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

      <?php include('../inc/footer.php'); ?>

</body>

</html>
