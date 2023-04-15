<?php   
session_start();
$id = mysqli_connect ("127.0.0.1", "root", "", "ece_book");
$idu = $_GET['idu'];
$req="select* from users where idu='$idu' ";
$res =mysqli_query($id, $req);
$profil=mysqli_fetch_assoc($res);

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

    <h1>profil de l'utilisateur :</h1>
    <?php 
        echo"     
        <div class='profil'> 
            <p> <img src=' ".$profil["photo"]." ' width='100' > </p>
            <p> nom : ".$profil['nom']." </p> 
            <p> prénom : ".$profil['prenom']." </p> 
            <p> email : ".$profil['email']." </p>
            <p> pseudo : ".$profil['nom_utilisateur']." </p>
            <p> promoE : ".$profil['promoE']." </p>
            <p> promoP : ".$profil['promoP']." </p>
            <p> date de naissance : ".$profil['date_de_naissance']." </p>
            <p> type utilisateur : ".$profil['type_utilisateur']." </p>
            <p> biographie : ".$profil['bio']." </p>
            <p> ville : ".$profil['ville']." </p>
        </div>
        ";
    ?>
    <h1> ses publications : </h1>
    <?php
    $req2 = "select* from publication where idu=".$profil['idu']."";
    $resultat = mysqli_query($id, $req2);
    
    //Ici, la fonction mysqli_num_rows est utilisée pour compter le nombre de lignes dans le résultat de la requête. Si ce nombre est supérieur à 0, la boucle while est exécutée pour afficher les publications. 
    //Sinon, un message indiquant que l'utilisateur n'a rien publié est affiché.
    if(mysqli_num_rows($resultat) > 0) { // Vérifie s'il y a des résultats dans la requête
      while ($historique = mysqli_fetch_assoc($resultat)) {
        echo"
          <div class='historique'>
            <p> <a href='detailPublication.php?idp=".$historique["idp"]." & idu=".$_SESSION["idu"]." & email=".$_SESSION['email']." ' =>  ".$historique["titre"]."  </a> </p> 
            <p> image: <img src=' ".$historique["image"]." ' width='100' > </p> 
            <p> description: ".$historique['description']." </p>
            <p> likes: ".$historique['likes']." </p> 
            <p> dislikes: ".$historique['dislikes']." </p> 
            <p> date publication: ".$historique['date']." </p> 
          </div>
          <br>
        ";
      }
    } 
    // la personne n'a encore rien posté
    else {
      echo "l'utilisateur n'a encore rien publié...";
    }
  ?>

  <h1> ses commentaires </h1>

  <?php

    $req2 = "select* from commentaires where idu=".$profil['idu']."";
    $resultat = mysqli_query($id, $req2);

    //Ici, la fonction mysqli_num_rows est utilisée pour compter le nombre de lignes dans le résultat de la requête. Si ce nombre est supérieur à 0, la boucle while est exécutée pour afficher les commentairess. 
    //Sinon, un message indiquant que l'utilisateur n'a rien publié est affiché.
    if(mysqli_num_rows($resultat) > 0) { // Vérifie s'il y a des résultats dans la requête
      while ($historique = mysqli_fetch_assoc($resultat)) {
        echo"
          <div class='historique'>
            <p>  ".$historique['texte']." </p> 
            <p>  ".$historique['date']." </p> 
            <p>  ".$historique['auteur']." </p>
          </div>
          <br>
        ";
      }
    } 
    // la personne n'a encore rien posté
    else {
      echo "Il n'a pas encore posté de commentaire...";
    }
  ?>
  <br><br>
  <a href="acceuil.php"> retour </a>
</body>
</html> 