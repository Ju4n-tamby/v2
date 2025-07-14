<?php
require("../inc/function.php");
if (isset($_GET['id_image'])) {
  $id_image = $_GET['id_image'];
  supprimerImage($id_image);
  header("Location: ../pages/fiche_objet.php?id_objet=" . $_GET['id_objet']);
  exit();
}
