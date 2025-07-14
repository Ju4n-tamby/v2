<?php
require("../inc/function.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['etat'])) {
  if (isset($_POST['id_emprunt'])) {
    $id_emprunts = $_POST['id_emprunt'];
    foreach ($id_emprunts as $id_emprunt) {
      retournerObjet($id_emprunt, $_POST['etat']);
    }
    header("Location: ../pages/fiche_membre.php?id_membre=" . $_SESSION['id']);
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Etat des objets</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/bootstrap-icons/font/bootstrap-icons.css" />
</head>

<body class="bg-dark text-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg">
          <div class="card-body bg-light">
            <h3 class="mb-4 text-dark"><i class="bi bi-clipboard-check"></i> Préciser l'état des objets</h3>
            <form action="" method="post">
              <?php
              if (isset($_POST['id_emprunt'])) {
                if (is_array($_POST['id_emprunt'])) {
                  foreach ($_POST['id_emprunt'] as $id) {
                    echo '<input type="hidden" name="id_emprunt[]" value="' . htmlspecialchars($id) . '">';
                  }
                } else {
                  echo '<input type="hidden" name="id_emprunt[]" value="' . htmlspecialchars($_POST['id_emprunt']) . '">';
                }
              }
              ?>
              <div class="mb-3">
                <label for="etat" class="form-label text-dark">État des objets :</label>
                <select name="etat" id="etat" class="form-select">
                  <option value="1">Bon</option>
                  <option value="0">Mauvais</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success w-100">Valider</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
