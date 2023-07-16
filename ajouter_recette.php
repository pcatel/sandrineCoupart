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



    <!-- traitement connexion et ajout BDD -->
    <?php include 'php/connect.php'; ?>
    <?php


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
            $visible = $_POST['visible'];
            $regimes = $_POST['regimes'];
            $allergies = $_POST['allergies'];

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

            // Redirection vers la page d'affichage des recettes
    ?>
            <?php
            header('Location: listeRecettes.php');
            exit(); ?>
    <?php
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
        die();
    }
    ?>
    <!-- Fin traitement BDD et ajout -->




    <!-- About Start -->
    <div class="container-xxl py-5">
        <form method="POST" action="creation_recette.php">
            <div class="row g-5">
                <div class="col-lg-2">
                    <?php include 'php/adminSide.php'; ?>

                </div>


                <!-- recettes -->

                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2"></p>
                    <p class="display-5  about"></p>
                    <p class=""></p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <td>
                                    <div class="form-outline "><label for="titre">Titre :</label> </div>
                                </td>
                                <td><input type="text" name="titre" id="titre" class="formField"></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="description">Description :</label> </div>
                                </td>
                                <td><textarea name="description" id="description" class="formField"></textarea></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="temps_preparation">Temps de préparation :</label> </div>
                                </td>
                                <td><input type="text" name="temps_preparation" id="temps_preparation"></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="temps_repos">Temps de repos :</label> </div>
                                </td>
                                <td><input type="text" name="temps_repos" id="temps_repos"></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="temps_cuisson">Temps de cuisson :</label></div>
                                </td>
                                <td><input type="text" name="temps_cuisson" id="temps_cuisson"></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="ingredients">Ingrédients :</label></div>
                                </td>
                                <td><textarea name="ingredients" id="ingredients" class="formField"></textarea></td>
                            </tr>


                            <tr>
                                <td>
                                    <div class="form-outline "><label for="etapes">Étapes :</label> </div>
                                </td>
                                <td><textarea name="etapes" id="etapes" class="formField"></textarea></td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="form-outline "><label for="visible">Visible :</label>
                                </td>

                                <td><input type="checkbox" name="visible" value="1"></td>
                            </tr>
                    </div>

                    </table>
                </div>
            </div>



            <!-- regimes -->



            <div class="col-lg-3 wow fadeIn" data-wow-delay="0.5s">


                <!-- Première ligne affiche les regimes liés à la recette-->
                <div class="row">
                    <div class="col">

                    <p class="fw-medium text-uppercase text-primary mb-2">Régimes associés</p>
                        <?php
                        $queryRegimes = "SELECT * FROM regimes";
                        $stmtRegimes = $conn->prepare($queryRegimes);
                        $stmtRegimes->execute();
                        $tousRegimes = $stmtRegimes->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($tousRegimes as $regime) {
                            echo '<input type="checkbox" name="regimes[]" value="' . $regime['Id'] . '"> ' . $regime['nom'] . '<br>';
                        }
                        ?>

<br><br>
                    </div>
                </div>
                <!-- Deuxième ligne affiche les allergies liées à la recette-->
                <div class="row">
                    <div class="col">

                    <p class="fw-medium text-uppercase text-primary mb-2">Allergies associées</p>
                        
                        <?php
                        $queryAllergies = "SELECT * FROM allergies";
                        $stmtAllergies = $conn->prepare($queryAllergies);
                        $stmtAllergies->execute();
                        $toutesAllergies = $stmtAllergies->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($toutesAllergies as $allergie) {
                            echo '<input type="checkbox" name="allergies[]" value="' . $allergie['Id'] . '"> ' . $allergie['nom'] . '<br>';
                        }
                        ?>


                    </div>
                </div>

                <br><br>
                <!-- troisèeme ligne -->
                <div class="row">
                    <div class="col">

                        <input type="submit" value="Ajouter la recette" class="btn btn-primary px-3 d-none d-lg-block">

                    </div>
                </div>
            </div>







    </div>
    </form>


    </div>
    <!-- About End -->










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