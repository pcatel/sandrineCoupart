<?php include 'php/connect.php'; ?>

<?php
// Récupération des données du formulaire
$idAllergie = $_POST['idAllergie'];
$nom = $_POST['nom'];
$description = $_POST['description'];


// Connexion à la base de données


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Mise à jour des données de la allergie
$query = "UPDATE allergies
          SET nom = :nom, description = :description
          WHERE id = :idAllergie";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR); 
$stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);

$stmt->execute();









// Redirection vers la page d'affichage des allergies
header('Location: listeAllergies.php');
exit();

// Fermeture de la connexion à la base de données
$conn = null;
?>
