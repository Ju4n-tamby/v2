<?php
function dbconnect()
{
  ini_set('display_errors', 1);
  static $connect = null;

  if ($connect === null) {
    $connect = mysqli_connect('localhost', 'root', '', 'db_s2_ETU003922');

    if (!$connect) {
      // Arrête le script et affiche une erreur si la connexion échoue
      die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
    }

    // Optionnel : définir l'encodage des caractères pour gérer les accents (UTF-8 recommandé)
    mysqli_set_charset($connect, 'utf8mb4');
  }

  return $connect;
}
