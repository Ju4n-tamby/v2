<?php
require("../inc/function.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom_objet = $_POST['nom_objet'];
  $id_categorie = $_POST['id_categorie'];
  $id_membre = $_SESSION['id'];
  $listeImages = [];

  if (isset($_FILES['image']) && !empty($_FILES['image']['name'][0])) {
    foreach ($_FILES['image']['name'] as $key => $name) {
      $tmp_name = $_FILES['image']['tmp_name'][$key];
      if ($tmp_name) {
        $listeImages[] = [
          'name' => $name,
          'tmp_name' => $tmp_name,
          'type' => $_FILES['image']['type'][$key],
          'error' => $_FILES['image']['error'][$key],
          'size' => $_FILES['image']['size'][$key]
        ];
      }
    }
  }

  $id_objet = ajouterObjet($nom_objet, $id_categorie, $id_membre, $listeImages);
  if ($id_objet) {
    echo "Objet ajouté avec succès. ID de l'objet : " . $id_objet;
    header("Location: ../pages/liste_objet.php");
  } else {
    echo "Erreur lors de l'ajout de l'objet.";
  }
}
