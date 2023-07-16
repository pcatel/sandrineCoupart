<?php include 'php/connect.php'; ?>

<?php
// Récupération des données du formulaire
$idRegime = $_POST['idRegime'];
$nom = $_POST['nom'];
$description = $_POST['description'];


// Connexion à la base de données


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Mise à jour des données de la allergie
$query = "UPDATE regimes
          SET nom = :nom, description = :description
          WHERE id = :idRegime";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR); 
$stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);

$stmt->execute();









// Redirection vers la page d'affichage des allergies
header('Location: listeRegimes.php');
exit();

// Fermeture de la connexion à la base de données
$conn = null;
?>
