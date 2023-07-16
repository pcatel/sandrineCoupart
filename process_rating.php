<?php
include 'php/connect.php';

$idRecette = $_POST['idRecette'];
$note = $_POST['note'];
$commentaire = $_POST['commentaire'];
$idUser = $_POST['idUser'];

try {
  // Connexion à la base de données
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Vérification si l'utilisateur a déjà voté pour cette recette
  $query = "SELECT note, commentaire FROM notes_recettes WHERE idRecette = :idRecette AND idUser = :idUser";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
  $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result) {
    // Utilisateur a déjà voté pour cette recette
    $votePrecedent = $result['note'];
    $commentairePrecedent = $result['commentaire'];
    $message = "Vous avez déjà voté pour cette recette.\n";
    $message .= "Votre vote précédent : $votePrecedent\n";
    $message .= "Votre commentaire précédent : $commentairePrecedent";
  } else {
    // Préparation de la requête d'insertion
    $query = "INSERT INTO notes_recettes (idRecette, note, commentaire, idUser) VALUES (:idRecette, :note, :commentaire, :idUser)";
    $stmt = $conn->prepare($query);

    // Lier les valeurs aux paramètres de la requête
    $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
    $stmt->bindParam(':note', $note, PDO::PARAM_INT);
    $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    // Exécution de la requête
    $stmt->execute();

    // Message de succès
    $message = "Votre note a été enregistrée avec succès.";
  }
} catch (PDOException $e) {
  // En cas d'erreur
  $message = "Une erreur s'est produite lors de l'enregistrement de votre note : " . $e->getMessage();
}

// Affichage du message dans une popup
echo "<script>alert('$message');</script>";
?>
