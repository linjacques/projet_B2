<?php
session_start();
var_dump($_SESSION);

if (isset($_POST["envoi"])) {
  $date=date('j-m-y');
  extract($_POST);
  $id= mysqli_connect("127.0.0.1", "root", "", "ece_book");
  $idp = $_GET['idp'];
  $req2="insert into commentaires (texte, idu, date, idp, auteur) VALUES ('{$commentaire}', '{$_SESSION["idu"]}' ,'{$date}' ,'{$idp}', '{$_SESSION["email"]}') ";
  $res=mysqli_query($id, $req2);
  echo"message posté! merci pour votre retour ;)";
  header("refresh:2, url=acceuil.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php if (isset($_SESSION["idu"])) {
    ?> <h1>donnez-nous votre avis</h1> <?php
    ?> <form action="" method ="POST"> <!-- formulaire que l'utilisateur doit remplir pour pouvoir poster -->
          <input type="text" name="commentaire" placeholder ="commentez" > <!--si pas remplie alors le premier code ne pourra pas envoyer les infos*)--> 
          <br>
          <input type="submit" value="envoyer" name ="envoi">
        </form>
      <?php }
      else {
          echo"pour poster un commentaire, veuillez vous <a href='connexion.php'  > connecter </a>";
      }  ?>
</body>
</html>