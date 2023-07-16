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
            < </div>
        </div>
        <!-- Page Header End -->


        <!-- About Start -->
        <div class="container-xxl py-5"> 
            <div class="container">
            <div class="row g-5">
                <div class="col-lg-2">
                    <?php include 'php/adminSide.php'; ?>

                </div>
                <?php include 'php/connect.php'; ?>

                <!-- recettes -->

                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2"></p>
                    <p class="display-5  about"></p>
                    <p class=""></p>

                    <?php
                    // Récupération de l'identifiant de la recette depuis l'URL

                    $idRecette = $_GET['id'];

                    // Connexion à la base de données


                    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
                    //$connection = mysqli_connect($host, $username, $password_db, $dbname);

                    // Récupération des informations de la recette
                    $query = "SELECT * FROM recettes WHERE Id = :id";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':id', $idRecette, PDO::PARAM_INT);
                    $stmt->execute();
                    $recette = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Vérification si la recette existe
                    if (!$recette) {
                        echo "La recette demandée n'existe pas.";
                        exit;
                    }

                    // Affichage du formulaire de modification de la recette
                    echo '<form action="modifier_recette.php" method="POST">';
                    echo '<div class="table-responsive">';
                    echo '<table  class="table table-hover">';

                    echo '<input type="hidden" name="idRecette" value="' . $recette['Id'] . '">';

                    echo '<tr><td><div class="form-outline"><label for="titre">Titre :</label></td>';
                    echo '<td><input type="text" name="titre" value="' . $recette['titre'] . '" class="formField"></td></tr></div>';


                    echo '<tr><td><div class="form-outline "><label for="description">Description :</label></td>';
                    echo '<td><textarea name="description" class="formField">' . $recette['description'] . '</textarea></td></tr></div>';

                    echo '<tr><td><div class="form-outline"><label for="temps_preparation">Temps de préparation :</label></td>';
                    echo '<td><input type="number" name="temps_preparation" value="' . $recette['temps_preparation'] . '"></td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="temps_repos">Temps de repos :</label></td>';
                    echo '<td><input type="number" name="temps_repos" value="' . $recette['temps_repos'] . '"></td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="temps_cuisson">Temps de cuisson :</label></td>';
                    echo '<td><input type="number" name="temps_cuisson" value="' . $recette['temps_cuisson'] . '"></td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="ingredients">Ingrédients :</label></td>';
                    echo '<td><textarea name="ingredients" class="formField">' . $recette['ingredients'] . '</textarea></td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="etapes">Étapes :</label></td>';
                    echo '<td><textarea name="etapes" class="formField">' . $recette['etapes'] . '</textarea></td></tr></div>';

                  
                    echo '<tr><td><div class="form-outline "><label for="visible">Visible :</label></td>';

echo '<td><input type="checkbox" name="visible" value="1" ' . ($recette['visible'] == 1 ? 'checked' : '') . '></td></tr></div>';



                   

                    echo '</table>';
                    ?>

</div>

                </div>



                <!-- regimes -->



                <div class="col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2"></p>
                    <p class="display-5  about"></p>
                    <p class=""></p>

                    <!-- Première ligne affiche les regimes liés à la recette-->
                    <div class="row">
                        <div class="col">
                            <?php
                            // Récupération des régimes associés à la recette
                            $query = "SELECT regimes.* FROM regimes_recettes
            LEFT JOIN regimes ON regimes_recettes.idRegime = regimes.Id
            WHERE regimes_recettes.idRecette = :idRecette";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
                            $stmt->execute();
                            $regimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Récupération de tous les régimes
                            $query = "SELECT * FROM regimes";
                            $stmt = $conn->query($query);
                            $tousRegimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Affichage des régimes avec cases à cocher
                            
                            echo'<p class="fw-medium text-uppercase text-primary mb-2">Régimes associés</p>';
                            foreach ($tousRegimes as $regime) {
                                $checked = in_array($regime, $regimes) ? 'checked' : '';
                                echo '<input type="checkbox" name="regimes[]" value="' . $regime['Id'] . '" ' . $checked . '> ' . $regime['nom'] . '<br>';
                            }
                            ?>
                        </div>
                    </div>

                    <br><br>
                    <!-- Deuxième ligne affiche les allergies liées à la recette-->
                    <div class="row">
                        <div class="col">


                            <?php
                            // Récupération des allergies associés à la recette
                            $query = "SELECT allergies.* FROM allergies_recettes
            LEFT JOIN allergies ON allergies_recettes.idallergie = allergies.Id
            WHERE allergies_recettes.idRecette = :idRecette";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
                            $stmt->execute();
                            $allergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Récupération de tous les régimes
                            $query = "SELECT * FROM allergies";
                            $stmt = $conn->query($query);
                            $tousallergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Affichage des régimes avec cases à cocher
                            echo'<p class="fw-medium text-uppercase text-primary mb-2">allergies associées</p>';
                            foreach ($tousallergies as $allergie) {
                                $checked = in_array($allergie, $allergies) ? 'checked' : '';
                                echo '<input type="checkbox" name="allergies[]" value="' . $allergie['Id'] . '" ' . $checked . '> ' . $allergie['nom'] . '<br>';
                            }
                            ?>


                        </div>
                    </div>

                    <br><br>
                    <!-- troisèeme ligne -->
                    <div class="row">
                        <div class="col">
                            <?php
                            echo '<input type="submit" value="Enregistrer les modifications" class="btn btn-primary px-3 d-none d-lg-block">';
                            // Fermeture de la connexion à la base de données
                            $conn = null;
                            ?>
                        </div>
                    </div>
                </div>







            </div>

        </div>
        </form>
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