<?php include 'php/connect.php'; ?>

<?php
// Récupération des données du formulaire
$idRecette = $_POST['idRecette'];
$titre = $_POST['titre'];
$description = $_POST['description'];
$tempsPreparation = $_POST['temps_preparation'];
$tempsRepos = $_POST['temps_repos'];
$tempsCuisson = $_POST['temps_cuisson'];
$ingredients = $_POST['ingredients'];
$etapes = $_POST['etapes'];
$visible = $_POST['visible'];
$regimes = $_POST['regimes'];
$allergies = $_POST['allergies'];

// Connexion à la base de données


$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

// Mise à jour des données de la recette
$query = "UPDATE recettes
          SET titre = :titre, description = :description, temps_preparation = :tempsPreparation,
              temps_repos = :tempsRepos, temps_cuisson = :tempsCuisson, ingredients = :ingredients, etapes = :etapes, visible = :visible 
          WHERE Id = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':tempsPreparation', $tempsPreparation, PDO::PARAM_INT);
$stmt->bindParam(':tempsRepos', $tempsRepos, PDO::PARAM_INT);
$stmt->bindParam(':tempsCuisson', $tempsCuisson, PDO::PARAM_INT);
$stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
$stmt->bindParam(':etapes', $etapes, PDO::PARAM_STR);
$stmt->bindParam(':visible', $visible, PDO::PARAM_INT);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Suppression des anciennes associations de régimes
$query = "DELETE FROM regimes_recettes WHERE idRecette = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Insertion des nouvelles associations de régimes
if (!empty($regimes)) {
    $query = "INSERT INTO regimes_recettes (idRegime, idRecette) VALUES (:idRegime, :idRecette)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
    foreach ($regimes as $idRegime) {
        $stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Suppression des anciennes associations d'allergies'
$query = "DELETE FROM allergies_recettes WHERE idRecette = :idRecette";
$stmt = $conn->prepare($query);
$stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
$stmt->execute();

// Insertion des nouvelles associations de régimes
if (!empty($allergies)) {
    $query = "INSERT INTO allergies_recettes (idAllergie, idRecette) VALUES (:idAllergie, :idRecette)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
    foreach ($allergies as $idAllergie) {
        $stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);
        $stmt->execute();
    }
}





// Redirection vers la page d'affichage des recettes
header('Location: listeRecettes.php');
exit();

// Fermeture de la connexion à la base de données
$conn = null;
?>
