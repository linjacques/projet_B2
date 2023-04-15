<?php
session_start();
$id = mysqli_connect("127.0.0.1","root","","ece_book");
$req="select* from users";
$res= mysqli_query ($id, $req);
$user= mysqli_fetch_assoc($res);
$idu = $user["idu"];
if (isset($_POST["s"]) AND $_POST["s"] == "Rechercher")
{
 $_POST["terme"] = htmlspecialchars($_POST["terme"]); //pour sécuriser le formulaire contre les failles html
 $terme = $_POST["terme"];
 $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
 $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
}

if (isset($terme))
{
 $terme = strtolower($terme);
 $req = "SELECT idu, nom, prenom,photo, LEFT(nom, 1) AS first_letter_nom, LEFT(prenom, 1) AS first_letter_prenom FROM users WHERE nom LIKE '$terme%' OR prenom LIKE '$terme%'";
 $res =mysqli_query($id,$req);
 
}
else
{
 $message = "Vous devez entrer votre requete dans la barre de recherche";
}


?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset = "utf-8" >
 </head>
 <body>
  
  <?php

    //verifie si la barre de recherche renvoie des users ou non
    if(mysqli_num_rows($res)>0) {
      ?> 
        <h1> résultats de votre recherche : </h1>
        <h1> voici les utilisateurs trouvé-es </h1> 
      <?php
      //affiche le ou les resultats de la barre de recherche
      while($terme_trouve=mysqli_fetch_assoc($res))
      {
        echo"     
          <div class='profil'> 
            <p> <img src=' ".$terme_trouve["photo"]." ' width='100' > </p>
            <p> <a href= 'profilUser.php?idu=".$terme_trouve["idu"]." '> ".$terme_trouve["nom"]." </a> </p> 
            <p> ".$terme_trouve['prenom']." </p> 
          </div>
        ";
        //si le nom entré dans la barre de recherche match le nom de l'user connecté
        if($terme_trouve['nom'] == $_SESSION['nom']) {
          // indiquer à l'user par un "vous", que l'user trouvé c'est lui
          echo" <h2> vous </h2> ";
        } else { // sinon, c'est les autres
            echo "<input type='button' value='Demande d ami'> 
            <br><br> <br>";
        }
      }
    } else {
      echo" <h1> aucun résultats trouvés... </h1>";
    } 
   ?>
    <br><br>
   <a href="acceuil.php"> retour</a>
 </body>
</html>
