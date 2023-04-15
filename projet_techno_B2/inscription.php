
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ece book - page d'inscription</title>
   <link rel="stylesheet" href="inscription.css">


</head>
<body>
    <h1> ece book </h1>
    
    <div class='inscription'>

    <h2> inscription </h2>
    <form action="recupclient" method="post" enctype="multipart/form-data">
     
        <input type="email" placeholder="email" name="email" required>
        <br>
        <input type="text" placeholder="nom" name="nom" required>
        <br>
        <input type="text" placeholder="prenom" name="prenom" required>
        <br>
        <input type="text" placeholder="nom d'utilisateur" name="nom_utilisateur" required>
        
        <p> Le mot de passe doit contenir une majuscule, un caractère et un chiffre.</p> 
        
        <input type="password" placeholder="mot de passe" minlength="8" name="mdp" required>
        <br>
        <input type="date" placeholder="date de naissance" name="date_de_naissance" required>
        <br>
        <input type="file" name="photo" >
        <br>
        <input type="text" name="bio" placeholder="biographie">
        <br>
        <input type="text" name="ville" placeholder="ville">
        <br>
        Type d'utilisateur : <br>
        <select name="type_utilisateur" id="">
            <option value="Etudiant">Etudiant</option>
            <option value="Professeur">Professeur</option>
        </select><br>
        Si vous êtes étudiant choisissez votre promotion :
        <br>
        <input type="radio" name="promoE" id="" value="Non concerne" checked>Non concerné
        <input type="radio" name="promoE" id="" value="ING1">ING1
        <input type="radio" name="promoE" id="" value="ING2">ING2
        <input type="radio" name="promoE" id="" value="ING3">ING3
        <input type="radio" name="promoE" id="" value="ING4">ING4
        <input type="radio" name="promoE" id="" value="ING5">ING5
        <input type="radio" name="promoE" id="" value="B1">B1 
        <input type="radio" name="promoE" id="" value="B2">B2
        <input type="radio" name="promoE" id="" value="B3">B3
        <input type="radio" name="promoE" id="" value="M1">M1
        <input type="radio" name="promoE" id="" value="M2">M2
        

        <br>
        Si vous êtes professeur choisissez les promotion dans lesquelles vous intervenez :
        <br>
        <input type="checkbox" name="promoP" id="P1" value="Non concerne" checked>Non concerné
        <input type="checkbox" name="promoP" id="P2" value="ING1">ING1
        <input type="checkbox" name="promoP" id="P3" value="ING2">ING2
        <input type="checkbox" name="promoP" id="P4" value="ING3">ING3
        <input type="checkbox" name="promoP" id="P5" value="ING4">ING4
        <input type="checkbox" name="promoP" id="P6" value="ING5">ING5
        <input type="checkbox" name="promoP" id="P7" value="B1">B1 
        <input type="checkbox" name="promoP" id="P8" value="B2">B2
        <input type="checkbox" name="promoP" id="P9" value="B3">B3
        <input type="checkbox" name="promoP" id="P10" value="M1">M1
        <input type="checkbox" name="promoP" id="P11" value="M2">M2
        <br>
        <input type="submit" name="bout">
    </form>
    </div>
    <h3>déjà un compte?</h3>
    <a href="connexion.php"> se connecter </a>
</body>
</html>
