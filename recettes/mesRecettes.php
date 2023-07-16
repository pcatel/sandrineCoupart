<?php
// Connexion à la base de données

$conn = new mysqli($host, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// ID de l'utilisateur spécifique
$userID = 10; // Remplacez 10 par l'ID de l'utilisateur que vous souhaitez récupérer

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

// Récupérer les régimes de l'utilisateur
$userRegimes = [];
$sqlUserRegimes = "SELECT idRegime FROM regimes_users WHERE idUser = $userID";
$resultUserRegimes = $conn->query($sqlUserRegimes);
if ($resultUserRegimes) {
    while ($rowUserRegimes = $resultUserRegimes->fetch_assoc()) {
        $userRegimes[] = $rowUserRegimes["idRegime"];
    }
} else {
    die("Erreur lors de la récupération des régimes de l'utilisateur : " . $conn->error);
}

// Vérifier si l'utilisateur a des allergies
if (!empty($userAllergies)) {
    // Récupérer les recettes avec des allergies différentes de l'utilisateur, groupées par régime
    echo "<h2>Recettes contre vos allergies :</h2>";
    $sqlAllergieRecettes = "SELECT r.titre, r.description, rg.nom AS nom_regime
                            FROM recettes r
                            LEFT JOIN allergies_recettes ar ON r.id = ar.idRecette
                            LEFT JOIN allergies a ON ar.idAllergie = a.id
                            LEFT JOIN regimes_recettes rr ON r.id = rr.idRecette
                            LEFT JOIN regimes rg ON rr.idRegime = rg.id
                            WHERE ar.idAllergie IS NULL OR ar.idAllergie NOT IN (" . implode(",", $userAllergies) . ")
                            ORDER BY rg.nom ASC";

    $resultAllergieRecettes = $conn->query($sqlAllergieRecettes);
    if ($resultAllergieRecettes && $resultAllergieRecettes->num_rows > 0) {
        echo "<table style='border-collapse: collapse; border: 1px solid black;'>";
        echo "<tr><th style='border: 1px solid black;'>Titre</th><th style='border: 1px solid black;'>Description</th><th style='border: 1px solid black;'>Régime</th></tr>";
        $currentRegime = '';
        while ($row = $resultAllergieRecettes->fetch_assoc()) {
            if ($row["nom_regime"] !== $currentRegime) {
                $currentRegime = $row["nom_regime"];
                echo "<tr><td colspan='3' style='border: 1px solid black; font-weight: bold;'>$currentRegime</td></tr>";
            }
            echo "<tr>";
            echo "<td style='border: 1px solid black;'>" . $row["titre"] . "</td>";
            echo "<td style='border: 1px solid black;'>" . $row["description"] . "</td>";
            echo "<td style='border: 1px solid black;'>" . ($row["nom_regime"] ?? "Aucun") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucune recette correspondante trouvée contre vos allergies.";
    }
} else {
    echo "L'utilisateur n'a pas d'allergies associées.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
