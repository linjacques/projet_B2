<?php
// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost:8889;dbname=ece_book", "root", "root");

// Récupération de la chaîne de recherche
$recherche = $_GET['users'];

// Requête SQL pour trouver les utilisateurs qui correspondent à la recherche
$requete = $connexion->prepare("SELECT * FROM users WHERE nom_utilisateur LIKE '%$recherche%'");
$requete->execute();
$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);

// Affichage des résultats
foreach($resultats as $resultat){
    echo "<div class='profil'>".$resultat['nom_utilisateur']."</div>
    <p> <a href= 'profilUser.php?idu=".$resultat["idu"]." '> ".$resultat["prenom"]." </a> </p>";
}
?>