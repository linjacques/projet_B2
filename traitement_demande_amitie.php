<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idu'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si les paramètres requis sont présents
if (!isset($_POST['id_sender']) || !isset($_POST['action'])) {
    header("Location: mes_amis.php");
    exit();
}

// Connexion à la base de données
$db_host = "127.0.0.1";
$db_user = "root";
$db_pass = "";
$db_name = "ece_book";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connexion à la base de données échouée: " . mysqli_connect_error());
}

// Récupérer l'id de l'utilisateur
$id_user = $_SESSION['idu'];

// Récupérer l'id de l'expéditeur de la demande d'amitié
$id_sender = $_POST['id_sender'];

// Vérifier si l'utilisateur est bien le destinataire de la demande d'amitié
$req = "SELECT id_receiver FROM friend_requests WHERE id_sender = '$id_sender' AND status = 'pending'";
$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors de la vérification de la demande d'amitié: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($res);

if ($row['id_receiver'] != $id_user) {
    header("Location: mes_amis.php");
    exit();
}

// Accepter ou refuser la demande d'amitié
$action = $_POST['action'];

if ($action == "accept") {
    $req = "UPDATE friend_requests SET status = 'accepted' WHERE id_sender = '$id_sender' AND id_receiver = '$id_user' AND status = 'pending'";
} else {
    $req = "DELETE FROM friend_requests WHERE id_sender = '$id_sender' AND id_receiver = '$id_user' AND status = 'pending'";
}

$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors du traitement de la demande d'amitié: " . mysqli_error($conn));
}

// Insérer les données dans la table "friends"
$req = "INSERT INTO friends (id_user, id_friend, status) VALUES ('$id_user', '$id_sender', 'accepted')";
$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors de l'insertion des données dans la table friends: " . mysqli_error($conn));
}
else if ($action == "reject") {

    // Rejeter la demande d'amitié
$req = "UPDATE friend_requests SET status = 'rejected' WHERE id_sender = '$id_sender' AND id_receiver = '$id_user'";
$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors du rejet de la demande d'amitié: " . mysqli_error($conn));
}
}

mysqli_close($conn);

// Rediriger l'utilisateur vers la page des amis
header("Location: mes_amis.php");
exit();
//Note : Ce code suppose que la table friend_requests a les colonnes suivantes : id_sender, id_receiver, status. La colonne status peut avoir les valeurs "pending" pour une demande d'amitié en attente, "accepted" pour une demande d'amitié acceptée, ou "rejected" pour une demande d'amitié rejetée.
?>


