<?php
require("../inc/function.php");

if (!isset($_SESSION["id"])) {
  header('Location: ../pages/login.php');
  exit();
}

$id_objet = isset($_GET['id_objet']) ? intval($_GET['id_objet']) : 0;
$id_membre = $_SESSION["id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_jours'])) {
  $nombre_jours = intval($_POST['nombre_jours']);
  emprunter($id_objet, $id_membre, $nombre_jours);
  header("Location: ../pages/liste_objet.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emprunter un objet</title>
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

  <div class="container mt-5">
    <form action="" method="post" class="card p-4 shadow-sm">
      <h2 class="mb-3">Emprunter l'objet</h2>
      <div class="mb-3">
        <label for="nombre_jours" class="form-label">Entrer le nombre de jours</label>
        <input type="number" name="nombre_jours" id="nombre_jours" class="form-control" required min="1">
      </div>
      <input type="hidden" name="id_objet" value="<?php echo htmlspecialchars($id_objet); ?>">
      <button type="submit" class="btn btn-primary">Emprunter</button>
    </form>
  </div>

</body>

</html>
