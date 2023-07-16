<?php
// Connexion à la base de données

$conn = new mysqli($host, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// ID de l'utilisateur spécifique
$userID = $_SESSION['IdCpteUser']; // Remplacez 10 par l'ID de l'utilisateur que vous souhaitez récupérer

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

// Vérifier si l'utilisateur a des régimes et des allergies
if (!empty($userRegimes) && !empty($userAllergies)) {
    // Récupérer les recettes qui ont des régimes identiques à l'utilisateur et des allergies différentes de l'utilisateur
    $sqlRecettes = "SELECT r.titre, r.description
                    FROM recettes r
                    INNER JOIN regimes_recettes rr ON r.id = rr.idRecette
                    INNER JOIN allergies_recettes ar ON r.id = ar.idRecette
                    WHERE rr.idRegime IN (" . implode(",", $userRegimes) . ")
                    AND ar.idAllergie NOT IN (" . implode(",", $userAllergies) . ")";

    // Afficher les recettes qui satisfont les conditions
    if ($resultRecettes = $conn->query($sqlRecettes)) {
        if ($resultRecettes->num_rows > 0) {
            echo "<h2>Les recettes pour les régimes identiques et allergies différentes :</h2>";
            echo "<table style='border-collapse: collapse; border: 1px solid black;'>";
            echo "<tr><th style='border: 1px solid black;'>Titre</th><th style='border: 1px solid black;'>Description</th></tr>";
            while ($row = $resultRecettes->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='border: 1px solid black;'>" . $row["titre"] . "</td>";
                echo "<td style='border: 1px solid black;'>" . $row["description"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune recette correspondante trouvée pour les régimes identiques et allergies différentes.";
        }
    } else {
        die("Erreur lors de l'exécution de la requête SQL : " . $conn->error);
    }
} else {
    echo "L'utilisateur n'a pas de régimes et/ou d'allergies associés.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
