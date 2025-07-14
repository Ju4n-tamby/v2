<?php
require("../inc/function.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["mail"];
  $mot_de_passe = $_POST["mdp"];
  $membre = getMembre($email, $mot_de_passe);
  if ($membre != null) {
    $_SESSION["id"] = $membre["id_membre"];
    header('Location:../pages/liste_objet.php');
  } else {
    echo "Identifiants invalides.";
  }
}
