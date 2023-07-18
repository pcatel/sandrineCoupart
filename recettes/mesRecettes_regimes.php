<?php
// Connexion à la base de données

$conn = new mysqli($host, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer les régimes
$sqlRegimes = "SELECT id, nom FROM regimes";
$resultRegimes = $conn->query($sqlRegimes);

if ($resultRegimes && $resultRegimes->num_rows > 0) {
    echo '<p class="fw-medium text-uppercase text-primary mb-2">Recettes supplémentaires</p>';
    echo '<table class="table table-hover table-bordered">';
    echo "<tr><th>Régime</th><th>Nbre</th></tr>";
    while ($rowRegime = $resultRegimes->fetch_assoc()) {
        $regimeID = $rowRegime["id"];
        $regimeNom = $rowRegime["nom"];

        // Récupérer le nombre de recettes visibles pour le régime
        $sqlRecettes = "SELECT COUNT(*) AS total_recettes
                        FROM recettes
                        INNER JOIN regimes_recettes ON recettes.id = regimes_recettes.idRecette
                        WHERE regimes_recettes.idRegime = $regimeID AND recettes.visible = 1";
        $resultRecettes = $conn->query($sqlRecettes);
        $rowRecettes = $resultRecettes->fetch_assoc();
        $totalRecettes = $rowRecettes["total_recettes"];

        echo "<tr>";
        echo "<td><a href='liste_recettes_regime_supp.php?regimeID=$regimeID' class='text-decoration-none link-success'>$regimeNom</a></td>";
        echo "<td>$totalRecettes</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<h2>Aucun régime trouvé.</h2>";
}

// Fermer la connexion à la base de données
$conn->close();
?>
