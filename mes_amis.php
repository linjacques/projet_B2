<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['idu'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$db_host = "localhost:8889";
$db_user = "root";
$db_pass = "root";
$db_name = "ece_book";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connexion à la base de données échouée: " . mysqli_connect_error());
}

// Récupérer les amis de l'utilisateur
$id_user = $_SESSION['idu'];

$req = "SELECT idu, prenom, nom FROM users INNER JOIN friends ON users.idu = friends.id_friend WHERE friends.id_user = '$id_user' AND friends.status = 'accepted'";
$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors de la récupération des amis: " . mysqli_error($conn));
}

$friends = array();

while ($row = mysqli_fetch_assoc($res)) {
    $friend = array(
        "id" => $row["idu"],
        "firstname" => $row["firstname"],
        "lastname" => $row["lastname"]
    );

    array_push($friends, $friend);
}

// Récupérer les demandes d'amitié en attente de l'utilisateur
$req = "SELECT users.idu, users.prenom, users.nom FROM users INNER JOIN friend_requests ON users.idu = friend_requests.id_sender WHERE friend_requests.id_receiver = '$id_user' AND friend_requests.status = 'pending'";
$res = mysqli_query($conn, $req);

if (!$res) {
    die("Erreur lors de la récupération des demandes d'amitié: " . mysqli_error($conn));
}

$friend_requests = array();

while ($row = mysqli_fetch_assoc($res)) {
    $friend_request = array(
        "id" => $row["idu"],
        "firstname" => $row["firstname"],
        "lastname" => $row["lastname"]
    );

    array_push($friend_requests, $friend_request);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mes amis</title>
</head>
<body>
    <h1>Mes amis</h1>

    <h2>Liste d'amis</h2>
    <?php if (count($friends) == 0) { ?>
        <p>Vous n'avez aucun ami pour le moment.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($friends as $friend) { ?>
                <li>
                    <a href="profil.php?idu=<?php echo $friend["id"]; ?>">
                        <?php echo $friend["firstname"] . " " . $friend["lastname"]; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <h2>Demandes d'amitié en attente</h2>
    <?php if (count($friend_requests) == 0) { ?>
        <p>Vous n'avez aucune demande d'amitié en attente pour le moment.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($friend_requests as $friend_request) { ?>
                <li>
                    <a href="profil.php?idu=<?php echo $friend_request["id"]; ?>">
                        <?php echo $friend_request["firstname"] . " " . $friend_request["lastname"]; ?>
</a>
<form method="post" action="traitement_demande_amitie.php">
<input type="hidden" name="id_sender" value="<?php echo $friend_request["id"]; ?>">
<input type="hidden" name="action" value="accept">
<input type="submit" value="Accepter">
</form>
<form method="post" action="traitement_demande_amitie.php">
<input type="hidden" name="id_sender" value="<?php echo $friend_request["id"]; ?>">
<input type="hidden" name="action" value="reject">
<input type="submit" value="Refuser">
</form>
</li>
<?php } ?>
</ul>
<?php } ?>

</body>
</html>
