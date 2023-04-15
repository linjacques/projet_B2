<?php  
session_start();

$id = mysqli_connect("127.0.0.1","root","","ece_book");
if(isset($_POST["envoyer"])) {
    extract($_POST);
    $mdp = MD5($mdp);
    $req = "select * from users
            where email='$email'
            and mdp='$mdp'";
    $res = mysqli_query($id, $req);
    //verifie si la requete renvoie un resultat (une ligne de la table) ou non
    if(mysqli_num_rows($res)>0) {
        //si correct alors:
        $ligne = mysqli_fetch_assoc($res);
        $_SESSION["idu"] = $ligne["idu"];
        $_SESSION["nom"] = $ligne["nom"];
        $_SESSION["niveau"] = $ligne["niveau"];
        $_SESSION["email"] = $email;
        //comme ca qu'on récupère un champ d'une table et l'insérer dans le tableau $_SESSION
        $_SESSION["prenom"] = $ligne["prenom"];
        $prenom = $_SESSION["prenom"];
        //le niveau 1 correspond à l'admin
        var_dump($_SESSION);
        if($_SESSION["niveau"]==1) {
        echo"<h1> bonjour administrateur $prenom ! </h1>";
        header("refresh:3, url=acceuil.php");
        } 
        // si user != admin, alors c'est un étudiant/prof
        else {
            echo"<h1> bonjour $prenom ! </h1>";
            header("refresh:3, url=acceuil.php");
        }
    } 
    //si mdp ou email saisie incorrect alors
    else { 
        echo"<h1> erreur : mot de passe ou email INVALIDE! </h1>";
        header("refresh:3, url=connexion.php");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ece book - page d'inscription</title>
    
    <link rel="stylesheet" href="connexion.css">

</head>

<body>
    <h1>ece book</h1>

    <div class="connexion">

        <!--<div class='connexion'> -->
            <h2> connexion</h2>

            <form action="" method="post">
                <input type="text" placeholder="email" name="email" required>
                <?php?>
                <br><br>
                <input type="password" placeholder="mot de passe" name="mdp"required>
                <br><br>
                <div class="text-center"><button type="submit" class="btn btn-primary text-center" name="envoyer">Se connecter</button></div>
            </form>
        <br><br>
        <h3> Pas encore membre ? </h3>
        <a href="inscription.php">inscrivez-vous</a>
    </div>
<br>
</body>
</html>