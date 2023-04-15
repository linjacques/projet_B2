<?php 
session_start();
// inclure le fichier contenant la fonction generateUniqueFilename()
include 'fonctions php/nomRandom.php';

$idu = $_GET["idu"]; 
//var_dump($idu);

$id = mysqli_connect("127.0.0.1", "root", "", "ece_book");

// Récupérez les données actuelles de l'utilisateur à partir de la base de données
$req = "SELECT * FROM users WHERE idu='$idu'";
$res = mysqli_query($id, $req);
$utilisateur = mysqli_fetch_assoc($res);
echo"<h2> ".$utilisateur['email']." </h2>";
if (isset($_POST["modifier"])) {
   extract($_POST);
   extract($_FILES);

   
   //$nom = !empty($nom) ? $nom : $utilisateur['nom']; 
   //Cette ligne vérifie si la variable $nom est vide ou non. Si elle n'est pas vide, elle lui attribue sa valeur actuelle (d'où le '$nom=' ). 
   //Si elle est vide, elle utilise la valeur $utilisateur['nom'], qui est stockée dans la base de données 
   $nom = !empty($nom) ? $nom : $utilisateur['nom'];  
   $prenom = !empty($prenom) ? $prenom : $utilisateur['prenom'];//$prenom = !empty($prenom) ? $prenom : $utilisateur['prenom']; Cette ligne fonctionne de la même manière que la précédente, mais pour la variable $prenom.
   //$email = !empty($email) ? $email : $utilisateur['email'];//$email = !empty($email) ? $email : $utilisateur['email']; Cette ligne fonctionne de la même manière que les deux précédentes, mais pour la variable $email.
   $mdp = !empty($mdp) ? $mdp : $utilisateur['mdp'];
   $nom_utilisateur = !empty($nom_utilisateur) ? $nom_utilisateur : $utilisateur['nom_utilisateur'];
   $promoE = !empty($promoE) ? $promoE : $utilisateur['promoE'];
   $promoP = !empty($promoP) ? $promoP : $utilisateur['promoP'];
   $date_de_naissance = !empty($date_de_naissance) ? $date_de_naissance : $utilisateur['date_de_naissance'];
   //$type_utilisateur = !empty($type_utilisateur) ? $type_utilisateur : $utilisateur['type_utilisateur'];
   $photo = !empty($photo) ? $photo : $utilisateur['photo'];
   $bio = !empty($bio) ? $bio : $utilisateur['bio'];
   $ville = !empty($ville) ? $ville : $utilisateur['ville'];

   
   // BLINDAGE : Si une nouvelle photo a été téléchargée
   if (!empty($_FILES['photo']['tmp_name'])) {
      var_dump($_FILES);
      // blindage : Vérifie que le nom du fichier contient:
      $extensions_autorisees = array('png', 'jpeg', 'jpg', 'gif', 'txt');
      $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
      if (!in_array($extension_upload, $extensions_autorisees)) {
         echo "<h2> Erreur : Seules les images de type png, jpeg, jpg et gif sont autorisées.</h2>";
         header("refresh:4, url=parametrecompte.php");
         exit;
      }
      // la fonction genererNomUnique se trouve dans le dossier fonction php
      $nomFichierUnique = genererNomUnique($_FILES['photo']['name']);
      // chemin du fichier photo dans le dossier photoProfil
      $cheminFichier = "photoProfil/".$nomFichierUnique;
      // déplace le fichier téléchargé dans le dossier photoProfil
      move_uploaded_file($_FILES['photo']['tmp_name'], $cheminFichier);
      
      // remplace l'ancien chemin par le nouveau chemin vers la nouvelle photo
      $photo = $cheminFichier;
      
   } else { // utilise l'ancien chemin si aucune nouvelle photo n'a été téléchargée
      $photo = $utilisateur['photo']; 
   }
   

   // BLINDAGE : si l'user saisie un nouveau mdp
   if(!empty($mdp) && $mdp != $utilisateur['mdp']) { // mdp non-null et mdp différent de ancien mdp = true 
      //Chaine de caractères spéciales requisent pour la création de mdp
      $regex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/";
      //verifie que le nouveau mdp respecte les Chaines de caractères spéciales requisent pour la création de mdp
      if(preg_match($regex, $mdp) ) {
         //change l'ancien mdp par le nouveau mdp crypté!
         $mdp = md5($mdp); //nouveau mdp saisie depuis le form
         //var_dump($mdp); //nouveau mdp saisie depuis le form
         //echo"if1";
      }  else { 
         echo "<h2> Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial. ET contenir 8 caractères 
         OU il ne doit pas être similaire à l'ancien mot de passe! </h2>";
         header("refresh:5, url=parametrecompte.php");
         //arreter le code ici si mdp non conforme!
         exit;
      }
   }  else {//sinon garder l'ancien mdp
      $mdp = $utilisateur['mdp'];
      //var_dump($mdp); //acien mdp
      //echo"if 2";
   } 


   // update la bdd avec les nouvelles valeurs
   $req = "UPDATE users SET nom='$nom'
                            , prenom='$prenom'
                            , mdp='$mdp'
                            , nom_utilisateur='$nom_utilisateur'
                            , promoE='$promoE'
                            , promoP='$promoP'
                            , date_de_naissance='$date_de_naissance'
                            , photo='{$photo}'
                            , bio='$bio'
                            , ville='$ville' 
                              WHERE idu='$idu'";
   $res = mysqli_query($id, $req);

   echo" <h1> modifications enregistrées ! </h1> ";
   //header("refresh:3, url=parametrecompte.php");
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
   <h1> veuillez saisir les nouvelles données vous concernant! </h1>

   <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" placeholder="photo de profil">
        <br>
        <input type="text" name="nom" placeholder="nom">
        <br>
        <input type="text" name="prenom" placeholder="prénom">
        <br>
        <input type="password" name="mdp" placeholder="mot de passe">
        <br>
        <input type="text" name="nom_utilisateur" placeholder="pseudo">
        <br>
        <input type="text" name="promoE" placeholder="promoE">
        <br>
        <input type="text" name="promoP" placeholder="promoP">
        <br>
        <input type="date" name="date_de_naissance" placeholder="date de naissance">
        <br>
        <input type="text" name="bio" placeholder="biographie">
        <br>
        <input type="text" name="ville" placeholder="ville">
        <br>
        <input type="submit" name="modifier">
   </form>

   <a href="parametrecompte.php"> annuler </a>
</body>
</html>