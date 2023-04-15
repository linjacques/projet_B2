<?php 
session_start();
// inclure le fichier contenant la fonction generateUniqueFilename()
include 'fonctions php/nomRandom.php';
$id= mysqli_connect("127.0.0.1", "root", "", "ece_book");
$req="select* from users where idu= ".$_SESSION['idu']." ";
$res=mysqli_query($id, $req);
$infoUser = mysqli_fetch_assoc($res);
//lien vers le profil user
echo" <a href= 'parametrecompte.php?idu= ".$_SESSION['idu']." '>    ".$infoUser['email']."   </a>";

if(isset($_POST["envoyer"])) {
    //extrait tout du formulaire post
    extract($_POST);
    extract($_FILES);

    //dossier permettant de stocker les images
    $dossierLocal = $_FILES["image"]["tmp_name"];
    
    // blindage : Vérifie que le nom du fichier contient:
    $extensions_autorisees = array('png', 'jpeg', 'jpg', 'gif', 'txt');
    $extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));
    if (!in_array($extension_upload, $extensions_autorisees)) {
    echo "<h2> Erreur : Seules les images de type png, jpeg, jpg et gif sont autorisées.</h2>";
    header("refresh:4, url=publication.php");
    exit;
    }

    // la fonction genererNomUnique se trouve dans le dossier fonction php
    $nomFichierUnique = genererNomUnique($_FILES['image']['tmp_name']);
    //chemin du fichier image dans  dossierImage (lien)
    $cheminFichier = "dossierImage/".$nomFichierUnique;
    
    //Il n'est pas recommandé d'insérer directement les images dans MYSQL mais plutôt les liens (chemin d'acces)
    // vers l'image, car cela poserait des problemes de performances
    $lien= move_uploaded_file($dossierLocal, $cheminFichier);
    //vérification
    if ($lien) { //if ($lien=true) 
        //connexion vers la BDD
        $id=mysqli_connect("127.0.0.1", "root", "", "ece_book");

        //on veut aussi récupérer la date de publication
        $date=date('j-m-y');
        $sql = "insert into publication (titre, description, image, auteur, likes, dislikes, date, idu, categories) 
                values ('$titre', '{$description}','{$cheminFichier}', ' {$_SESSION["email"]} ', 0, 0, '{$date}', ' {$_SESSION["idu"]} ', '$categories') ";
        //insertion des données dans la BDD
        $res = mysqli_query($id, $sql);
        var_dump($_FILES);
        echo"<h2> votre publication a bien été postée! </h2>";
        //header("refresh:3, url=acceuil.php");
    } else {
        echo"<h2> Erreur lors du transfert de données vers le serveur... Veuillez rééssayer </h2> ";
    }
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
    <h1>publier un post</h1>

    <div class="formulaire">
        <form method="post" action="" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="titre" required>
        <br><br>
        <input type="text" name="description" placeholder="bio">
        <br><br>
        <input type="file" name="image" required>
        <br><br>
        <select name="categories" id="">
            <option value="general">général</option>
            <option value="actualite">actualités</option>
            <option value="evenement">événement</option>
        </select>
        <br><br>
        <input type="submit" name="envoyer" value="envoyer">
        </form>
    </div>

    <a href="acceuil.php">retour</a>
</body>
</html>