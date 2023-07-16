<?php include 'php/connect.php'; ?>

<?php
// Récupération de l'identifiant de la user à supprimer depuis l'URL
$idUser = $_GET['id'];

// Vérification de l'existence de l'identifiant de la user
if (empty($idUser)) {
    // Redirection vers une page d'erreur ou de gestion des erreurs
    header('Location: erreur.php');
    exit();
}

// Connexion à la base de données
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Vérification de la confirmation de suppression
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {
// Suppression des anciennes associations de régimes
$query = "DELETE FROM regimes_users WHERE idUser = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Suppression des anciennes associations d'allergies
$query = "DELETE FROM allergies_users WHERE idUser = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Suppression de la user
$query = "DELETE FROM users WHERE Id = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Fermeture de la connexion à la base de données
$conn = null;

   // Redirection vers la page d'affichage des users
   header('Location: listeUsers.php');
   exit();
} else {
   // Affichage de la confirmation de suppression en JavaScript
   echo '<script>
       if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
           window.location.href = "supprimer_user.php?id=' . $idUser . '&confirm=1";
       } else {
           window.location.href = "listeUsers.php";
       }
   </script>';
}

?>
