<?php include 'php/connect.php'; ?>

<?php
// Récupération de l'identifiant de la recette à supprimer depuis l'URL
$idRecette = $_GET['id'];

// Vérification de l'existence de l'identifiant de la recette
if (empty($idRecette)) {
    // Redirection vers une page d'erreur ou de gestion des erreurs
    header('Location: erreur.php');
    exit();
}

// Connexion à la base de données
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Vérification de la confirmation de suppression
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {
// Suppression des anciennes associations de régimes
$query = "DELETE FROM regimes_recettes WHERE idRecette = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Suppression des anciennes associations d'allergies
$query = "DELETE FROM allergies_recettes WHERE idRecette = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Suppression de la recette
$query = "DELETE FROM recettes WHERE Id = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Fermeture de la connexion à la base de données
$conn = null;

   // Redirection vers la page d'affichage des recettes
   header('Location: listeRecettes.php');
   exit();
} else {
   // Affichage de la confirmation de suppression en JavaScript
   echo '<script>
       if (confirm("Êtes-vous sûr de vouloir supprimer cette recette ?")) {
           window.location.href = "supprimer_recette.php?id=' . $idRecette . '&confirm=1";
       } else {
           window.location.href = "listeRecettes.php";
       }
   </script>';
}

?>
