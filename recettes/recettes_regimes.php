

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

// Vérifier si l'utilisateur a des régimes
if (!empty($userRegimes)) {
    // Récupérer les noms des régimes de l'utilisateur
    $regimeNoms = [];
    $sqlRegimes = "SELECT nom FROM regimes WHERE id IN (" . implode(",", $userRegimes) . ")";
    $resultRegimes = $conn->query($sqlRegimes);
    if ($resultRegimes) {
        while ($rowRegimes = $resultRegimes->fetch_assoc()) {
            $regimeNoms[] = $rowRegimes["nom"];
        }
    } else {
        die("Erreur lors de la récupération des noms des régimes : " . $conn->error);
    }

    // Récupérer les recettes liées aux régimes de l'utilisateur
    $sqlRegimeRecettes = "SELECT r.titre, r.description, rg.nom AS nom_regime
                          FROM recettes r
                          INNER JOIN regimes_recettes rr ON r.id = rr.idRecette
                          INNER JOIN regimes rg ON rr.idRegime = rg.id
                          WHERE rr.idRegime IN (" . implode(",", $userRegimes) . ")";

    // Afficher les recettes pour chaque régime de l'utilisateur
    if ($resultRegimeRecettes = $conn->query($sqlRegimeRecettes)) {
        if ($resultRegimeRecettes->num_rows > 0) {
            echo "<h2>Les recettes pour vos régimes :</h2>";
            foreach ($regimeNoms as $regimeNom) {
                echo "<h3>Recettes pour votre régime : $regimeNom</h3>";
                echo "<table style='border-collapse: collapse; border: 1px solid black;'>";
                echo "<tr><th style='border: 1px solid black;'>Titre</th><th style='border: 1px solid black;'>Description</th></tr>";
                $recettesTrouvees = false;
                while ($row = $resultRegimeRecettes->fetch_assoc()) {
                    if ($row["nom_regime"] === $regimeNom) {
                        $recettesTrouvees = true;
                        echo "<tr>";
                        echo "<td style='border: 1px solid black;'>" . $row["titre"] . "</td>";
                        echo "<td style='border: 1px solid black;'>" . $row["description"] . "</td>";
                        echo "</tr>";
                    }
                }
                if (!$recettesTrouvees) {
                    echo "<tr><td colspan='2' style='border: 1px solid black;'>Pas de recette pour ce régime.</td></tr>";
                }
                echo "</table>";
                // Réinitialiser le pointeur de résultat pour la prochaine itération de la boucle
                $resultRegimeRecettes->data_seek(0);
            }
        } else {
            echo "Aucune recette correspondante trouvée pour vos régimes.";
        }
    } else {
        die("Erreur lors de l'exécution de la requête SQL : " . $conn->error);
    }
} else {
    echo "L'utilisateur n'a pas de régimes associés.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
