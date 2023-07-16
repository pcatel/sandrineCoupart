<?php include 'php/connect.php'; ?>

<?php
// Récupération des données du formulaire
$idUser = $_POST['idUser'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];
$typeUser = $_POST['typeUser'];
$regimes = $_POST['regimes'];
$allergies = $_POST['allergies'];

// Connexion à la base de données


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Mise à jour des données de la user
$query = "UPDATE users
          SET nom = :nom, prenom = :prenom, email = :email,
              mot_de_passe = :mot_de_passe, typeUser = :typeUser
          WHERE Id = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
$stmt->bindParam(':typeUser', $typeUser, PDO::PARAM_STR);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Suppression des anciennes associations de régimes
$query = "DELETE FROM regimes_users WHERE idUser = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Insertion des nouvelles associations de régimes
if (!empty($regimes)) {
    $query = "INSERT INTO regimes_users (idRegime, idUser) VALUES (:idRegime, :idUser)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    foreach ($regimes as $idRegime) {
        $stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Suppression des anciennes associations d'allergies'
$query = "DELETE FROM allergies_users WHERE idUser = :idUser";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
$stmt->execute();

// Insertion des nouvelles associations de régimes
if (!empty($allergies)) {
    $query = "INSERT INTO allergies_users (idAllergie, idUser) VALUES (:idAllergie, :idUser)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    foreach ($allergies as $idAllergie) {
        $stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);
        $stmt->execute();
    }
}





// Redirection vers la page d'affichage des users
header('Location: listeUsers.php');
exit();

// Fermeture de la connexion à la base de données
$conn = null;
?>
