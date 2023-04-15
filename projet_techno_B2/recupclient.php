<?php
// inclure le fichier contenant la fonction generateUniqueFilename()
include 'fonctions php/nomRandom.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
session_start();
$conn = mysqli_connect("127.0.0.1","root","","ece_book");
mysqli_set_charset($conn,"utf8");
    if(isset($_POST["bout"])){
        
        $regex = "/^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/";
        $intervenant ='@ece.fr' ;
        $code_activation = bin2hex(random_bytes(16));
        //extrait le form
        extract($_POST);
        extract($_FILES);
        
        //dossier permettant de stocker les photos
        $dossierLocal = $_FILES["photo"]["tmp_name"];
        // blindage : Vérifie que le nom du fichier contient:
        $extensions_autorisees = array('png', 'jpeg', 'jpg');
        $extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
        if (!in_array($extension_upload, $extensions_autorisees)) {
        echo "<h2> Erreur : Seules les photos de type png, jpeg, et jpg sont autorisées.</h2>";
        header("refresh:4, url=inscription.php");
        exit;
        }
        // la fonction genererNomUnique se trouve dans le dossier fonction php
        $nomFichierUnique = genererNomUnique($_FILES['photo']['name']);
        //chemin du fichier photo dans  dossierphoto (lien)
        $cheminFichier = "photoProfil/".$nomFichierUnique;
        $lien= move_uploaded_file($dossierLocal, $cheminFichier);


        $niveau = 0;
        $req1 = "select * from users where email='$email'";
        $res1 = mysqli_query($conn, $req1);
        if(mysqli_num_rows($res1)){
        echo "<h1>Un compte existe deja avec cette adresse mail<h1>";
        header("refresh:3, url=inscription.php");

        }else if(preg_match($regex, $mdp)) {
            $mdp = MD5($mdp);
            
            //prof
            if($type_utilisateur == "Professeur"){
            
                if (strpos($email,$intervenant)==false){
                    echo"veuillez rentrer une adresse email valide, ex : nom@ece.fr";
                    header("refresh:3, url=inscription.php");
                }   
                
                if (strripos($email,$intervenant)< strripos($email,'.')){
                
                $req = "insert into users (nom, prenom, email, mdp, nom_utilisateur, promoE, promoP, date_de_naissance, type_utilisateur, niveau, code_activation, activation, photo, bio, ville)
                                                  VALUES ('$nom', '$prenom', '$email', '$mdp', '$nom_utilisateur', '$promoE', 
                                                  '$promoP', '$date_de_naissance', '$type_utilisateur', 0, '$code_activation', 0, 
                                                   '{$cheminFichier}', '$bio', '$ville') ";
                $resultat_insertion = mysqli_query($conn, $req);

                    if ($resultat_insertion) {
                        // Générer un code d'activation aléatoire
                        $code_activation = bin2hex(random_bytes(16));
                        
                        // Enregistrer le code d'activation dans la base de données
                        $sql = "UPDATE users SET code_activation='$code_activation' WHERE email='$email'";
                        $resultat = mysqli_query($conn, $sql);
                        
                        // Envoyer un e-mail d'activation à l'utilisateur
                        $to = $email;
                        $subject = 'Activation de votre compte';
                        $message = 'Bonjour ' . $nom_utilisateur . ',<br><br>';
                        $message .= 'Merci de vous être inscrit sur notre site. Pour activer votre compte, veuillez cliquer sur le lien suivant :<br><br>';
                        $message .= '<a href="http://example.com/activation.php?email=' . urlencode($email) . '&code=' . urlencode($code_activation) . '">Activer mon compte</a><br><br>';
                        $message .= 'Cordialement,<br>';
                        $message .= 'L\'équipe de notre site';
                        $headers = "Content-Type : text/plain; charset=utf-8\r\n";
                        $headers .= "From: yohann.carlier07@gmail.com\r\n";
                        mail($to, $subject, $message, $headers);
                        
                        // Afficher un message de confirmation à l'utilisateur
                        echo 'Votre compte a été créé avec succès. Un e-mail d\'activation a été envoyé à votre adresse e-mail. Veuillez cliquer sur le lien dans cet e-mail pour activer votre compte.';
                        echo "<h1>Nous vous confirmons la création de votre compte, vous pouvez maintenant vous connecter</h1>";
                        header("refresh:5, url=connexion.php"); 
                    }
                }
            }
            //étudiant
            else{
                
                $req2 = "insert into users (nom, prenom, email, mdp, nom_utilisateur, promoE, promoP, date_de_naissance, type_utilisateur, niveau, code_activation, activation, photo, bio, ville) 
                        VALUES ('$nom', '$prenom', '$email', '$mdp', '$nom_utilisateur', '$promoE', '$promoP', 
                        '$date_de_naissance', '$type_utilisateur', 0, '$code_activation', 0, '{$cheminFichier}', '$bio', '$ville') ";
                $resultat_insertion = mysqli_query($conn, $req2);
               
                if ($resultat_insertion) {
                    // Générer un code d'activation aléatoire
                    $code_activation = bin2hex(random_bytes(16));
                    
                    // Enregistrer le code d'activation dans la base de données
                    $sql = "UPDATE users SET code_activation='$code_activation' WHERE email='$email'";
                    $resultat = mysqli_query($conn, $sql);
                    
                    // Envoyer un e-mail d'activation à l'utilisateur
                    $to = $email;
                    $subject = 'Activation de votre compte';
                    $message = 'Bonjour ' . $nom_utilisateur . ',<br><br>';
                    $message .= 'Merci de vous être inscrit sur notre site. Pour activer votre compte, veuillez cliquer sur le lien suivant :<br><br>';
                    $message .= '<a href="http://example.com/activation.php?email=' . urlencode($email) . '&code=' . urlencode($code_activation) . '">Activer mon compte</a><br><br>';
                    $message .= 'Cordialement,<br>';
                    $message .= 'L\'équipe de notre site';
                    $headers = "Content-Type : text/plain; charset=utf-8\r\n";
                    $headers .= "From: yohann.carlier07@gmail.com\r\n";
                    mail($to, $subject, $message, $headers);
                    
                    // Afficher un message de confirmation à l'utilisateur
                    echo 'Votre compte a été créé avec succès. Un e-mail d\'activation a été envoyé à votre adresse e-mail. Veuillez cliquer sur le lien dans cet e-mail pour activer votre compte.';
                    echo "<h1>Nous vous confirmons la création de votre compte, vous pouvez maintenant vous connecter</h1>";
                    header("refresh:5, url=connexion.php");
                }
                
            }
        }        
                else {
                    echo "Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.";
                    header("refresh:5, url=inscription.php");
                }
            
        
    }
?>
</body>
</html>