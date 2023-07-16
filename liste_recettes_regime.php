<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sandrine Coupart Diététicienne-Nutritionniste</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <?php include 'php/head.php'; ?>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->


  <!-- connexion -->

  <?php include 'php/connect.php';  ?>

<?php
// Connexion à la base de données

$conn = new mysqli($host, $username, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer l'ID du régime sélectionné
$regimeID = $_GET['regimeID']; // L'ID du régime sélectionné passé en paramètre dans l'URL

// Vérifier si l'ID du régime est valide
if (!empty($regimeID)) {
    // Récupérer le nom du régime et le nombre de recettes
    $sqlRegime = "SELECT nom FROM regimes WHERE id = $regimeID";
    $resultRegime = $conn->query($sqlRegime);
    if ($resultRegime && $resultRegime->num_rows > 0) {
        $rowRegime = $resultRegime->fetch_assoc();
        $regimeNom = $rowRegime["nom"];

        // Récupérer les recettes pour le régime spécifique
        $sqlRecettes = "SELECT r.id, r.titre, r.description, a.nom AS nom_allergie
                        FROM recettes r
                        LEFT JOIN allergies_recettes ar ON r.id = ar.idRecette
                        LEFT JOIN allergies a ON ar.idAllergie = a.id
                        INNER JOIN regimes_recettes rr ON r.id = rr.idRecette
                        WHERE rr.idRegime = $regimeID
                        AND r.visible = 1"; // Exclure les recettes dont la case "visible" est égale à 1

?>

    <!-- Fin connexion -->





 


    <?php include 'php/navbar.php'; ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight   SiteName1">Liste des recettes</h1>
            <
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="row gx-3 h-100">
                        <div class="col-6 align-self-start wow fadeInUp" data-wow-delay="0.1s">
                            <img class="img-fluid" src="img/about-1.jpg">
                        </div>
                        <div class="col-6 align-self-end wow fadeInDown" data-wow-delay="0.1s">
                            <img class="img-fluid" src="img/about-2.jpg">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    
                    <?php   $resultRecettes = $conn->query($sqlRecettes);
        if ($resultRecettes && $resultRecettes->num_rows > 0) {

            
            
            echo "<p class='fw-medium text-uppercase text-primary mb-2'>$resultRecettes->num_rows recettes pour le régime $regimeNom</p>";
            echo "<table class='table table-hover table-bordered'>";
            echo "<tr><th>Nom</th><th>Description</th><th>Allergie</th></tr>";
            while ($row = $resultRecettes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" ."<a href='fiche_recette.php?id=" . $row["id"] . "' class='text-decoration-none link-success'>" . $row["titre"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . ($row["nom_allergie"] ?? "-") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<h2>Aucune recette visible pour le régime : $regimeNom</h2>";
        }
    } else {
        echo "<h2>Régime invalide.</h2>";
    }
} else {
    echo "<h2>Aucun régime sélectionné.</h2>";
}

// Fermer la connexion à la base de données
$conn->close();
?>
                   
                 
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


   


   


    <!-- Video Modal Start -->
    <div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Youtube Video</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <?php include 'php/footer.php'; ?>

    


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
            class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>