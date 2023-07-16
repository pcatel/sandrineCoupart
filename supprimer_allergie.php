<?php include 'php/connect.php'; ?>

<?php
// Récupération de l'identifiant de la allergie à supprimer depuis l'URL
$idAllergie = $_GET['id'];

// Vérification de l'existence de l'identifiant de la allergie
if (empty($idAllergie)) {
    // Redirection vers une page d'erreur ou de gestion des erreurs
    header('Location: erreur.php');
    exit();
}

// Connexion à la base de données
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Vérification de la confirmation de suppression
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {


// Suppression de la allergie
$query = "DELETE FROM allergies WHERE Id = :idAllergie";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);
$stmt->execute();

// Fermeture de la connexion à la base de données
$conn = null;

   // Redirection vers la page d'affichage des allergies
   header('Location: listeAllergies.php');
   exit();
} else {
   // Affichage de la confirmation de suppression en JavaScript
   echo '<script>
       if (confirm("Êtes-vous sûr de vouloir supprimer cette allergie ?")) {
           window.location.href = "supprimer_allergie.php?id=' . $idAllergie . '&confirm=1";
       } else {
           window.location.href = "listeAllergies.php";
       }
   </script>';
}

?>
