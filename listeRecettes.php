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
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    <?php include 'php/navbar.php'; ?>

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight   SiteName1">Administration</h1>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-2">
                    <?php include 'php/adminSide.php'; ?>
                </div>
                <div class="col-lg-10 wow fadeIn" data-wow-delay="0.5s">
                    <?php include 'php/connect.php'; ?>

                    <?php
                    // Informations de connexion à la base de données
                 
                    try {
                        // Connexion à la base de données avec PDO
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                        die('La connexion à la base de données a échoué : ' . $e->getMessage());
                    }

                    // Requête pour récupérer les recettes avec les régimes associés et les allergies associées
                    $query = "
                        SELECT r.id, r.titre, r.description, r.temps_preparation, r.temps_repos, r.temps_cuisson, r.ingredients, r.etapes, r.visible, GROUP_CONCAT(DISTINCT reg.nom SEPARATOR ', ') AS regimes, GROUP_CONCAT(DISTINCT allg.nom SEPARATOR ', ') AS allergies
                        FROM recettes AS r
                        LEFT JOIN regimes_recettes AS rr ON r.id = rr.idRecette
                        LEFT JOIN regimes AS reg ON rr.idRegime = reg.id
                        LEFT JOIN allergies_recettes AS ar ON r.id = ar.IdRecette
                        LEFT JOIN allergies AS allg ON ar.IdAllergie = allg.Id
                        GROUP BY r.id
                        ORDER BY r.id";

                    $stmt = $conn->query($query);

                    // Vérification de la requête
                    if (!$stmt) {
                        die('La requête a échoué : ' . 
                        $conn->errorInfo());
                    }

                     // Récupérer le nombre d'utilisateurs
                    
                     $numRows = $stmt->rowCount(); 
                     ?>
                   
                     <p class="fw-medium text-uppercase text-primary mb-2">Liste des recettes (<?php echo $numRows; ?>)</p>

                    <?php 
                    
                     // Affichage du tableau des recettes avec les régimes et les allergies associées
                    echo '<table class="table">';
                    echo '<tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Visible</th>
                            <th>Régimes</th>
                            <th>Allergies</th>
                          </tr>';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['titre'] . '</td>';
                        echo '<td>' . $row['description'] . '</td>';
                        echo '<td>' . ($row['visible'] ? 'Oui' : 'Non') . '</td>';
                        echo '<td>' . $row['regimes'] . '</td>';
                        echo '<td>' . $row['allergies'] . '</td>';
                        echo '<td><a href="edit_recette.php?id=' . $row['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                      </svg></a></td>';?>
                        
                        <?php  echo '<td><a href="supprimer_recette.php?id=' . $row['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-trash3-fill" viewBox="0 0 16 16">
  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
</svg></a></td>';
                        echo '</tr>';
                    }

                    echo '</table>';

                    // Fermeture de la connexion à la base de données
                    $conn = null;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Video Modal Start -->
    <div class="modal modal-video fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Youtube Video</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->

    <?php include 'php/footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

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
