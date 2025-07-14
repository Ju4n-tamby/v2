<?php
require("../inc/function.php");

if (!isset($_GET['id_membre'])) {
  header('Location: liste_objet.php');
  exit();
}

$id_membre = $_GET['id_membre'];
$membre = getMembreParId($id_membre);

if (!$membre) {
  header('Location: liste_objet.php');
  exit();
}

$objets = getObjetsParMembre($id_membre);

// Regrouper les objets par catégorie
$objetsParCategorie = [];
foreach ($objets as $objet) {
  $cat = $objet['nom_categorie'];
  if (!isset($objetsParCategorie[$cat])) {
    $objetsParCategorie[$cat] = [];
  }
  $objetsParCategorie[$cat][] = $objet;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Fiche membre - <?php echo htmlspecialchars($membre['nom']); ?></title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body class="bg-light">
  <?php include('../inc/header.php'); ?>
  <div class="container py-4">
    <a href="liste_objet.php" class="btn btn-secondary mb-3"><- Retour</a>
        <div class="card shadow mb-4">
          <div class="card-body">
            <h1 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($membre['nom']); ?></h1>
            <p><strong>Email :</strong> <?php echo htmlspecialchars($membre['email']); ?></p>
          </div>
        </div>
        <div class="card shadow mb-4">
          <div class="card-body">
            <h2 class="card-title mb-3 text-dark"><i class="bi bi-box-seam"></i> Objets du membre</h2>
            <?php if (!empty($objetsParCategorie)) { ?>
              <?php foreach ($objetsParCategorie as $categorie => $objets) { ?>
                <h4 class="mt-4 text-success"><?php echo htmlspecialchars($categorie); ?></h4>
                <div class="row g-3 mb-3">
                  <?php foreach ($objets as $objet) { ?>
                    <div class="col-12 col-md-6 col-lg-4">
                      <div class="card h-100 shadow-sm">
                        <a href="fiche_objet.php?id_objet=<?php echo $objet['id_objet']; ?>" class="bg-white rounded shadow-sm p-3 flex-grow-1 link link-unstyled d-block h-100" style="min-width:250px; max-width:350px; text-decoration: none;">
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
                                echo '<span class="text-danger fw-bold">' . htmlspecialchars($emprunt['date_retour']) . '</span>';
                              } else {
                                echo '<span class="text-muted">Aucun emprunt en cours</span>';
                              }
                              ?>
                            </p>
                          </article>
                        </a>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            <?php } else { ?>
              <div class="alert alert-info">Ce membre n'a aucun objet.</div>
            <?php } ?>
          </div>
        </div>

        <?php if ($membre['id_membre'] == $_SESSION['id']) { ?>
          <div class="card shadow mb-4">
            <div class="card-body">
              <h1 class="fw-bold text-dark mb-3"><i class="bi bi-journal-bookmark"></i> Liste Emprunt en cours :</h1>
              <?php $emprunts_en_cours = genererListeEmpruntEnCours($membre['id_membre']); ?>
              <?php if (!empty($emprunts_en_cours)) { ?>
                <form action="../traitement/rendre.php" method="post">
                  <ul class="list-group">
                    <?php foreach ($emprunts_en_cours as $emprunt) { ?>
                      <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div>
                          <strong>Objet :</strong> <?php echo htmlspecialchars($emprunt['nom_objet']); ?><br>
                          <strong>Date emprunt :</strong> <?php echo htmlspecialchars($emprunt['date_emprunt']); ?><br>
                          <strong>Date retour :</strong> <?php echo htmlspecialchars($emprunt['date_retour']); ?>
                          <input type="hidden" name="id_emprunt[]" value="<?php echo $emprunt['id_emprunt']; ?>">
                        </div>
                      </li>
                    <?php } ?>
                  </ul>
                  <div class="mt-3 d-flex justify-content-end">
                    <input type="submit" class="btn btn-warning" value="Retourner la sélection">
                  </div>
                </form>
              <?php } else { ?>
                <div class="alert alert-info">Aucun emprunt en cours.</div>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
  </div>
</body>

</html>
