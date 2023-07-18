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

    // Afficher les recettes pour chaque régime de l'utilisateur
    foreach ($regimeNoms as $regimeNom) {
        

        // Compter le nombre de recettes trouvées pour ce régime
        $sqlCountRecettes = "SELECT COUNT(*) AS total_recettes FROM recettes r
                             INNER JOIN regimes_recettes rr ON r.id = rr.idRecette
                             INNER JOIN regimes rg ON rr.idRegime = rg.id
                             WHERE rg.nom = '$regimeNom'";

        $resultCountRecettes = $conn->query($sqlCountRecettes);
        if ($resultCountRecettes && $rowCountRecettes = $resultCountRecettes->fetch_assoc()) {
            $totalRecettes = $rowCountRecettes['total_recettes'];
        } else {
            $totalRecettes = 0;
        }
echo "<p class='fw-medium text-uppercase text-primary mb-2'>Régime : " . $regimeNom  ." (". $totalRecettes .  ")</p>";
        

        $sqlRegimeRecettes = "SELECT r.id, r.titre, r.description
                              FROM recettes r
                              INNER JOIN regimes_recettes rr ON r.id = rr.idRecette
                              INNER JOIN regimes rg ON rr.idRegime = rg.id
                              WHERE rg.nom = '$regimeNom'";

        $resultRegimeRecettes = $conn->query($sqlRegimeRecettes);
        if ($resultRegimeRecettes && $resultRegimeRecettes->num_rows > 0) {
            echo '<table class="table table-hover table-bordered">';
            while ($row = $resultRegimeRecettes->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='fiche_recette.php?id=" . $row["id"] . "' class='text-decoration-none link-success'>" . $row["titre"] . "</a></td>";
             
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Pas de recette pour ce régime.</p>";
        }
    }
} else {
    echo "L'utilisateur n'a pas de régimes associés.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
