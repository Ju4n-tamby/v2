<?php
require("connection.php");
session_start();

function inscrire_membre($nom, $date_naissance, $genre, $ville, $mail, $mdp, $image)
{
  $mysqli = new mysqli('localhost', 'root', '', 'db_s2_ETU003922');
  $sql = "INSERT INTO emp_membre (nom, datenaissance, genre, ville, email, mdp, image) VALUES ('$nom', '$date_naissance', '$genre', '$ville', '$mail', '$mdp', '$image')";
  if ($mysqli->query($sql) === true) {
    $inserted_id = $mysqli->insert_id;
    return $inserted_id;
  } else {
    return null;
  }
}

function upload_image($file)
{
  $uploadDir = dirname(__DIR__) . '/assets/image/';
  $maxSize = 3 * 1024 * 1024; // 3 Mo
  $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/avif', 'image/webp'];

  if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
    die('Aucun fichier n’a été téléchargé.');
  }
  if ($file['error'] !== UPLOAD_ERR_OK) {
    die('Erreur lors de l’upload : ' . $file['error']);
  }
  if ($file['size'] > $maxSize) {
    die('Le fichier est trop volumineux.');
  }

  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $file['tmp_name']);
  finfo_close($finfo);
  if (!in_array($mime, $allowedMimeTypes)) {
    die('Type de fichier non autorisé : ' . $mime);
  }

  $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
  $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
  $newName = $originalName . '_' . uniqid() . '.' . $extension;

  if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
    return $newName;
  } else {
    die("Échec du déplacement du fichier.");
  }
}

function getMembre($email, $mot_de_passe)
{
  $sql = "SELECT * FROM emp_membre WHERE email='$email' AND mdp='$mot_de_passe' LIMIT 1";
  $news_req = mysqli_query(dbconnect(), $sql);
  $user = array();
  if ($result = mysqli_fetch_assoc($news_req)) {
    $user = $result;
    return $user;
  } else {
    return null;
  }
}

function getMembreParId($id_membre)
{
  $sql = "SELECT * FROM emp_membre WHERE id_membre='$id_membre' LIMIT 1";
  $news_req = mysqli_query(dbconnect(), $sql);
  $user = array();
  if ($result = mysqli_fetch_assoc($news_req)) {
    $user = $result;
    return $user;
  } else {
    return null;
  }
}

function getAllObjets()
{
  $sql = "SELECT * FROM v_objet_categorie_membre GROUP BY id_objet DESC";
  $news_req = mysqli_query(dbconnect(), $sql);
  $objets = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $objets[] = $result;
  }
  return $objets;
}

function getAllCategories()
{
  $sql = "SELECT * FROM emp_categorie_objet";
  $news_req = mysqli_query(dbconnect(), $sql);
  $categories = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $categories[] = $result;
  }
  return $categories;
}

function getObjetsParCategories($id_categorie)
{
  $sql = "SELECT * FROM v_objet_categorie_membre WHERE id_categorie='$id_categorie' GROUP BY id_objet DESC";
  $news_req = mysqli_query(dbconnect(), $sql);
  $objets = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $objets[] = $result;
  }
  return $objets;
}

function verifier_emprunt_en_cours($id_objet)
{
  $sql = "SELECT * FROM emp_emprunt WHERE id_objet='$id_objet' AND (date_retour IS NULL OR date_retour > NOW()) LIMIT 1";
  $news_req = mysqli_query(dbconnect(), $sql);
  $emprunt = null;
  if ($result = mysqli_fetch_assoc($news_req)) {
    $emprunt = $result;
  }
  return $emprunt;
}

function afficherImage($nom)
{
  if (empty($nom)) {
    return '<i class="bi bi-box-seam text-danger" style="font-size: 3rem;"></i>';
  } else {
    $src = "../assets/image/" . htmlspecialchars($nom);
    return '<img src="' . $src . '" alt="Image" style="width:80px;height:80px;border-radius:50%">';
  }
}

function addImageObjet($id_objet, $listeImages)
{
  foreach ($listeImages as $image) {
    $image = upload_image($image);
    $sql = "INSERT INTO emp_images_objet (id_objet, nom_image) VALUES ('$id_objet', '$image')";
    mysqli_query(dbconnect(), $sql);
  }
}

function ajouterObjet($nom_objet, $id_categorie, $id_membre, $listeImages)
{
  $sql = "INSERT INTO emp_objet (nom_objet, id_categorie, id_membre) VALUES ('$nom_objet', '$id_categorie', '$id_membre')";
  if (mysqli_query(dbconnect(), $sql)) {
    $id_objet = mysqli_insert_id(dbconnect());
    addImageObjet($id_objet, $listeImages);
    return $id_objet;
  } else {
    return null;
  }
}

function getImage($id_objet)
{
  $sql = "SELECT * FROM emp_images_objet WHERE id_objet='$id_objet' ORDER BY id_image ASC";
  $news_req = mysqli_query(dbconnect(), $sql);
  $images = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $images[] = $result;
  }
  return $images;
}

function getCheminImage($nom_image)
{
  return "../assets/image/" . htmlspecialchars($nom_image);
}

function getObjetParId($id_objet)
{
  $sql = "SELECT * FROM v_objet_categorie_membre WHERE id_objet='$id_objet' LIMIT 1";
  $news_req = mysqli_query(dbconnect(), $sql);
  if ($result = mysqli_fetch_assoc($news_req)) {
    return $result;
  } else {
    return null;
  }
}

function getHistoriqueEmprunts($id_objet)
{
  $sql = "SELECT * FROM emp_emprunt WHERE id_objet='$id_objet' ORDER BY date_emprunt DESC";
  $news_req = mysqli_query(dbconnect(), $sql);
  $emprunts = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $emprunts[] = $result;
  }
  return $emprunts;
}

function supprimerImage($id_image)
{
  $sql = "DELETE FROM emp_images_objet WHERE id_image='$id_image'";
  mysqli_query(dbconnect(), $sql);
}

function getObjetsParMembre($id_membre)
{
  $sql = "SELECT * FROM v_objet_categorie_membre WHERE id_membre='$id_membre' ORDER BY id_objet DESC";
  $news_req = mysqli_query(dbconnect(), $sql);
  $objets = array();
  while ($result = mysqli_fetch_assoc($news_req)) {
    $objets[] = $result;
  }
  return $objets;
}
