<?php
session_start();
$id = ("127.0.0.1", "root", "", "ece_book");
$req = "select * from friend_request";
$res($id,$req);
$idneeded = mysqli_fetch_assoc($res);
$id_sender = $idneeded['id_sender'];
$id_receiver = $idneeded['id_receiver'];
$req = "INSERT INTO friend_requests (id_sender, id_receiver, status,) VALUES ('$id_sender', '$id_receiver', 'pending')";
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idu'])) {
    header("Location: login.php");
    exit();
}
//Récupération de l'id destinataire
if(isset($_GET['idu'])){
    $id_receiver=$_GET['idu'];
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

// Vérifier si l'ID de l'utilisateur destinataire est fourni dans l'URL
if (!isset($id_receiver)) {
    die("ID de l'utilisateur destinataire manquant.");
}

//$id_receiver = $_GET['id_receiver'];

// Vérifier si l'utilisateur destinataire existe dans la base de données
$req = "SELECT * FROM users WHERE idu = '$id_receiver'";
$res = mysqli_query($conn, $req);

if (mysqli_num_rows($res) == 0) {
    die("L'utilisateur destinataire n'existe pas.");
}

// Vérifier si une demande d'amitié existe déjà entre les deux utilisateurs
$id_sender = $_SESSION['idu'];

$req = "SELECT * FROM friend_requests WHERE id_sender = '$id_sender' AND id_receiver = '$id_receiver'";
$res = mysqli_query($conn, $req);

if (mysqli_num_rows($res) > 0) {
    die("Une demande d'amitié existe déjà entre ces deux utilisateurs.");
}

// Insérer une nouvelle demande d'amitié dans la table "friend_requests"
$req = "INSERT INTO friend_requests (id_sender, id_receiver, status) VALUES ('$id_sender', '$id_receiver', 'pending')";

if (mysqli_query($conn, $req)) {
    echo "Demande d'amitié envoyée avec succès.";
} else {
    echo "Erreur lors de l'envoi de la demande d'amitié: " . mysqli_error($conn);
}

mysqli_close($conn);
?>