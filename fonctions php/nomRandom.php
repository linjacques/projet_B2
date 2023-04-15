<?php

function genererNomUnique($image) {
    $extension = pathinfo($image, PATHINFO_EXTENSION); // Récupère l'extension du fichier
    $nomParDefaut = pathinfo($image, PATHINFO_FILENAME); // Récupère le nom de base du fichier (sans l'extension)
    $nomUnique = uniqid(); // Génère une chaîne unique
    return $nomParDefaut . "_" . $nomUnique . "." . $extension; // Retourne un nom de fichier unique
}

?>