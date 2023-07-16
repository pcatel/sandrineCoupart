<?php
// Connexion à la base de données

$conn = new mysqli($host, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// ID de l'utilisateur spécifique
$userID = $_SESSION['IdCpteUser']; // Remplacez 10 par l'ID de l'utilisateur que vous souhaitez récupérer

// Récupérer les allergies de l'utilisateur
$userAllergies = [];
$sqlUserAllergies = "SELECT idAllergie FROM allergies_users WHERE idUser = $userID";
$resultUserAllergies = $conn->query($sqlUserAllergies);
if ($resultUserAllergies) {
    while ($rowUserAllergies = $resultUserAllergies->fetch_assoc()) {
        $userAllergies[] = $rowUserAllergies["idAllergie"];
    }
} else {
    die("Erreur lors de la récupération des allergies de l'utilisateur : " . $conn->error);
}

// Vérifier si l'utilisateur a des allergies
if (!empty($userAllergies)) {
    // Récupérer les noms des allergies de l'utilisateur
    $allergieNoms = [];
    $sqlAllergies = "SELECT nom FROM allergies WHERE id IN (" . implode(",", $userAllergies) . ")";
    $resultAllergies = $conn->query($sqlAllergies);
    if ($resultAllergies) {
        while ($rowAllergies = $resultAllergies->fetch_assoc()) {
            $allergieNoms[] = $rowAllergies["nom"];
        }
    } else {
        die("Erreur lors de la récupération des noms des allergies : " . $conn->error);
    }

    // Récupérer les recettes qui ont les mêmes allergies que l'utilisateur, groupées par allergies
    $sqlAllergieRecettes = "SELECT r.titre, r.description, a.nom AS nom_allergie
                            FROM recettes r
                            INNER JOIN allergies_recettes ar ON r.id = ar.idRecette
                            INNER JOIN allergies a ON ar.idAllergie = a.id
                            WHERE ar.idAllergie IN (" . implode(",", $userAllergies) . ")";

    // Afficher les recettes pour chaque allergie de l'utilisateur
    if ($resultAllergieRecettes = $conn->query($sqlAllergieRecettes)) {
        if ($resultAllergieRecettes->num_rows > 0) {
            echo "<h2>Les recettes pour vos allergies :</h2>";
            foreach ($allergieNoms as $allergieNom) {
                echo "<h3>Recettes pour votre allergie : $allergieNom</h3>";
                echo "<table style='border-collapse: collapse; border: 1px solid black;'>";
                echo "<tr><th style='border: 1px solid black;'>Titre</th><th style='border: 1px solid black;'>Description</th></tr>";
                $recettesTrouvees = false;
                while ($row = $resultAllergieRecettes->fetch_assoc()) {
                    if ($row["nom_allergie"] === $allergieNom) {
                        $recettesTrouvees = true;
                        echo "<tr>";
                        echo "<td style='border: 1px solid black;'>" . $row["titre"] . "</td>";
                        echo "<td style='border: 1px solid black;'>" . $row["description"] . "</td>";
                        echo "</tr>";
                    }
                }
                if (!$recettesTrouvees) {
                    echo "<tr><td colspan='2' style='border: 1px solid black;'>Pas de recette pour cette allergie.</td></tr>";
                }
                echo "</table>";
                // Réinitialiser le pointeur de résultat pour la prochaine itération de la boucle
                $resultAllergieRecettes->data_seek(0);
            }
        } else {
            echo "Aucune recette correspondante trouvée pour vos allergies.";
        }
    } else {
        die("Erreur lors de l'exécution de la requête SQL : " . $conn->error);
    }
} else {
    echo "L'utilisateur n'a pas d'allergies associées.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
