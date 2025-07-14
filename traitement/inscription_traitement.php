<?php
require("../inc/function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nom = $_POST["nom"];
  $date_naissance = $_POST["date_naissance"];
  $genre = $_POST["genre"];
  $mail = $_POST["mail"];
  $ville = $_POST["ville"];
  $mdp = $_POST["mdp"];
  $image = $_FILES["image"]["name"];
  if ($image != null) {
    $image = upload_image($_FILES["image"]);
  }
  $id = inscrire_membre($nom, $date_naissance, $genre, $ville, $mail, $mdp, $image);
  if ($id) {
    $_SESSION["id"] = $id;
    header('Location:../pages/liste_objet.php');
  } else {
    echo "Erreur lors de l'inscription.";
  }
}
