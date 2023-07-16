<?php
// traitement connexion et ajout BDD
include 'php/connect.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $tempsPreparation = $_POST['temps_preparation'];
        $tempsRepos = $_POST['temps_repos'];
        $tempsCuisson = $_POST['temps_cuisson'];
        $ingredients = $_POST['ingredients'];
        $etapes = $_POST['etapes'];
        $visible = isset($_POST['visible']) ? 1 : 0; // Vérifie si la case est cochée ou non
        $regimes = isset($_POST['regimes']) ? $_POST['regimes'] : array();
        $allergies = isset($_POST['allergies']) ? $_POST['allergies'] : array();

        $query = "INSERT INTO recettes (titre, description, temps_preparation, temps_repos, temps_cuisson, ingredients, etapes, visible)
              VALUES (:titre, :description, :tempsPreparation, :tempsRepos, :tempsCuisson, :ingredients, :etapes, :visible)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':tempsPreparation', $tempsPreparation, PDO::PARAM_INT);
        $stmt->bindParam(':tempsRepos', $tempsRepos, PDO::PARAM_INT);
        $stmt->bindParam(':tempsCuisson', $tempsCuisson, PDO::PARAM_INT);
        $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
        $stmt->bindParam(':etapes', $etapes, PDO::PARAM_STR);
        $stmt->bindParam(':visible', $visible, PDO::PARAM_INT);
        $stmt->execute();

        $idRecette = $conn->lastInsertId();

        if (!empty($regimes)) {
            $query = "INSERT INTO regimes_recettes (idRegime, idRecette) VALUES (:idRegime, :idRecette)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
            foreach ($regimes as $idRegime) {
                $stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        if (!empty($allergies)) {
            $query = "INSERT INTO allergies_recettes (idAllergie, idRecette) VALUES (:idAllergie, :idRecette)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
            foreach ($allergies as $idAllergie) {
                $stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        // Redirection vers index.php
        header('Location: admin.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
?>
