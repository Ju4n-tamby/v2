<?php
$id = $_GET['id_objet'];
echo $id;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <form action="../pages/liste_objet.php" method="post">
    <p>Entrer le nombre de jour <input type="number" name="nombre_jours" required></p>
    <input type="hidden" name="id_objet" value="<?php echo $id; ?>">
    <button type="submit" class="btn btn-primary">Emprunter</button>
  </form>

</body>

</html>
