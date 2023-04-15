<?php
session_start();
$id= mysqli_connect("127.0.0.1", "root", "", "ece_book");
$req="select* from users where idu= ".$_SESSION['idu']." ";
$res=mysqli_query($id, $req);
$infoUser = mysqli_fetch_assoc($res);
//var_dump($_SESSION);
//var_dump($_SESSION["idu"]);

        // si l'user est connecté!
        if (isset($_SESSION['email'])) {?>
            <!-- alors montrer le lien vers son profil -->
          <?php  echo" <a href= 'parametrecompte.php?idu= ".$_SESSION['idu']." '>    ".$infoUser['email']."   </a>"; //le mail récupéré grace au fetch_assoc
        } else { // Dans le cas contraire:
            // L'inviter à se connecter!
            echo" <a href='connexion.php'> se connecter </a>";
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

    <h1> Acceuil : </h1>

    <?php
        // si l'user est connecté!
        if (isset($_SESSION['email'])) {?>
            <!-- alors laisser poster -->
            <a href="publication.php"> poster </a>
    <?php } 
        else { // Dans le cas contraire:
            // L'empêcher de le faire
            echo" vous devez vous connecter pour pouvoir poster une publication! ";
            
        }
   ?>

    <h1> publication </h1>

    <p>chercher un utilisateur:</p>
    <form action = "resultatRecherche.php" method = "post">
        <input type = "search" name = "terme" required>
        <input type = "submit" name = "s" value = "Rechercher">
    </form>
        
    <?php  
    //récupère les publications depuis la BDD
    $req= "select * from users INNER JOIN publication on users.idu = publication.idu";
    $res = mysqli_query($id, $req);
    
    // affiche les publications
    //var_dump($_SESSION);
    while ($publication=mysqli_fetch_assoc($res)) {
        
        echo"
        <div class='publication'> 
            <div class='publicationWITHIN'>
                <p> <img src=' ".$publication["photo"]." '  ' width='100' ></p>
                <p> " .$publication["nom_utilisateur"]. " </p>
                <p> " .$publication["titre"]. " </p>
                <a href= 'detailPublication.php?idp=".$publication["idp"]." & idu=".$_SESSION["idu"]." & email= ".$_SESSION['email']."  '> <img src=' ".$publication["image"]." ' width='100' > </a> 
            </div>
        </div>
        <br><br>  
        "; 
        // le ' ".publication["image"]." ' correspond au champ "image" de la table publication
        // ce champ, contient non l'image en lui-même MAIS le chemin d'acces menant aux images!
        // pour le prouver : supprimer les images manuellement depuis le dossier "dossierImage"
        // cela, ne supprimera pas les valeurs (donc le chemins d'acces) contenus dans le champ "image" de la table publication
        // Mais, cela supprime les images DANS le dossier "dossierImage"!
        // MAIS Le chemin menant au dossier "dossierImage" existe toujours dans la table publication, au champ "image"! 
        // Sauf que... Le chemin menant au dossier "dossierImage", ne contient à présent rien... 
        // essayez maintenant d'afficher les images depuis la BDD, 
        // Ca ne marchera pas car l'image dans le dossier "dossierImage" n'existe plus... Malgré que le chemin menant à ce dossier exsite toujours! 
    }    
    ?>
    <a href="deconnexion.php"> se deconnecter </a>
</body>
</html>