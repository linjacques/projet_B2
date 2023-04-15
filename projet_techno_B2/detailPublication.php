<?php
session_start();
$id= mysqli_connect("127.0.0.1", "root", "", "ece_book");
$req ="select * from publication";
$res = mysqli_query($id, $req);
$info = mysqli_fetch_assoc($res);
$idu = $_SESSION["idu"];
$idp = $_GET['idp'];
$req2="select* from publication where idp='$idp'";
$res2 = mysqli_query($id,$req2);
$detail = mysqli_fetch_assoc($res2);
$date=date('j-m-y');
//var_dump($idp);
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
    
    <h1>publication en détail</h1>
    <?php 
        echo"
            <div class='detail'>  
                    <p> <img src= ' ".$detail["image"]." ' width='100px'> </p>
                    <p> <h1> ".$detail['titre']." </h1> </p>
                    <p> description : ".$detail['description']." </p>
                    <p>auteur  <a href= 'profilUser.php?idu=".$detail["idu"]." '> ".$detail["auteur"]." </a> </p>
                    <p> date de publication: ".$detail['date']." </p>
                    <p> categories :  ".$detail['categories']."  </p>
                    <p>  likes : ".$detail['likes']." </p>
                    <p>  dislikes : ".$detail['dislikes']." </p>
                   
                    <a href= 'likes.php?idp= ".$detail['idp']." & idu=".$_SESSION['idu']." & email=".$_SESSION['email']."'>   emmetre un avis   </a>
            </div>
        ";
    ?>  

    <h2> section commentaires :</h2>
    <ul> 
        <?php  // affiche l'ensemble des messages des users pour la publication idp
                    
            $id = mysqli_connect("127.0.0.1", "root", "", "ece_book") ; 
            $req="select * from publication"; 
            $res = mysqli_query($id, $req);
            $info = mysqli_fetch_assoc($res); 
            $idp = $_GET['idp'];
            //var_dump($idp);
            $req2 = "select* from commentaires where idp= '$idp' ";
            $resultat2 = mysqli_query($id, $req2);   
            //verifie si la requete sql renvoie des lignes    
            if(mysqli_num_rows($resultat2)>0) {
                while ($ligne = mysqli_fetch_assoc($resultat2)) 
                { ?>
                    <div class="message">
                        <?=$ligne ["date"]?>        
                        <?=$ligne ["auteur"]?>
                        <?=$ligne ["texte"]?> 

                    </div> 
                    <br>
                <?php } 
            } else{//0 commentaire n'a été posté dans cette publication
                echo"0 commentaires sous la publication";
            }?>
    </ul>

    <br><br>
    <a href="acceuil.php">retour</a>
</body>
</html>