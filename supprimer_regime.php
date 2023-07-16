<?php include 'php/connect.php'; ?>

<?php
// Récupération de l'identifiant de la regime à supprimer depuis l'URL
$idRegime = $_GET['id'];

// Vérification de l'existence de l'identifiant de la regime
if (empty($idRegime)) {
    // Redirection vers une page d'erreur ou de gestion des erreurs
    header('Location: erreur.php');
    exit();
}

// Connexion à la base de données
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Vérification de la confirmation de suppression
if (isset($_GET['confirm']) && $_GET['confirm'] === '1') {


// Suppression de la regime
$query = "DELETE FROM regimes WHERE Id = :idRegime";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
$stmt->execute();

// Fermeture de la connexion à la base de données
$conn = null;

   // Redirection vers la page d'affichage des regimes
   header('Location: listeRegimes.php');
   exit();
} else {
   // Affichage de la confirmation de suppression en JavaScript
   echo '<script>
       if (confirm("Êtes-vous sûr de vouloir supprimer ce regime ?")) {
           window.location.href = "supprimer_regime.php?id=' . $idRegime . '&confirm=1";
       } else {
           window.location.href = "listeRegimes.php";
       }
   </script>';
}

?>
