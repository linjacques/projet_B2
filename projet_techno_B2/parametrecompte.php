<?php
session_start();

$id = mysqli_connect("127.0.0.1","root","","ece_book");
mysqli_set_charset($id,"utf8");
$idu=$_SESSION["idu"];
$req = "select * from users where idu ='$idu'";
$res = mysqli_query($id, $req);
$infoUser = mysqli_fetch_assoc($res);

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

  <h1>profil utilisateur :</h1>

  <?php  echo" <a href= 'editercompte.php?idu= ".$_SESSION['idu']." '>   ".$infoUser['email']."  </a>"; ?>

  <?php 
    echo"     
      <div class='profil'> 
        <p> <img src=' ".$infoUser["photo"]." ' width='100' > </p>
        <p> nom : ".$infoUser['nom']." </p> 
        <p> prénom : ".$infoUser['prenom']." </p> 
        <p> email : ".$infoUser['email']." </p>
        <p> mdp : ".$infoUser['mdp']." </p> 
        <p> pseudo : ".$infoUser['nom_utilisateur']." </p>
        <p> promoE : ".$infoUser['promoE']." </p>
        <p> promoP : ".$infoUser['promoP']." </p>
        <p> date de naissance : ".$infoUser['date_de_naissance']." </p>
        <p> type utilisateur : ".$infoUser['type_utilisateur']." </p>
        <p> niveau : ".$infoUser['niveau']." </p>
        <p> biographie : ".$infoUser['bio']." </p>
        <p> ville : ".$infoUser['ville']." </p>
      </div>
    ";
  ?>

  <h1> mes publications : </h1>
  <?php
    $req2 = "select* from publication where idu=".$_SESSION['idu']."";
    $resultat = mysqli_query($id, $req2);
    
    //Ici, la fonction mysqli_num_rows est utilisée pour compter le nombre de lignes dans le résultat de la requête. Si ce nombre est supérieur à 0, la boucle while est exécutée pour afficher les publications. 
    //Sinon, un message indiquant que l'utilisateur n'a rien publié est affiché.
    if(mysqli_num_rows($resultat) > 0) { // Vérifie s'il y a des résultats dans la requête
      while ($historique = mysqli_fetch_assoc($resultat)) {
        echo"
          <div class='historique'>
            <p> titre: ".$historique['titre']." </p> 
            <p> image: <img src=' ".$historique["image"]." ' width='100' > </p> 
            <p> description: ".$historique['description']." </p>
            <p> likes: ".$historique['likes']." </p> 
            <p> dislikes: ".$historique['dislikes']." </p> 
            <p> date publication: ".$historique['date']." </p> 
            <p> idp: ".$historique['idp']." </p> 
          </div>
          <br>
        ";
      }
    } 
    // la personne n'a encore rien posté
    else {
      echo "Vous n'avez encore rien publié...";
    }
  ?>


  <h1> mes commentaires </h1>

  <?php

    $req2 = "select* from commentaires where idu=".$_SESSION['idu']."";
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
      echo "Vous n'avez pas encore posté de commentaire...";
    }
  ?>





  <br><br>
  <a href="acceuil.php">retour</a>
</body>
</html>