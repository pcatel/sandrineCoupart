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

                    <!-- users -->

                    <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s">
                        <p class="fw-medium text-uppercase text-primary mb-2"></p>
                        <p class="display-5  about"></p>
                        <p class=""></p>

                        <?php
                        // Récupération de l'identifiant de la user depuis l'URL

                        $idUser = $_GET['id'];

                        // Connexion à la base de données


                        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
                        //$connection = mysqli_connect($host, $username, $password_db, $dbname);

                        // Récupération des informations de la user
                        $query = "SELECT * FROM users WHERE Id = :id";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
                        $stmt->execute();
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Vérification si la user existe
                        if (!$user) {
                            echo "L'utlisateur demandée n'existe pas.";
                            exit;
                        }

                        // Affichage du formulaire de modification de la user
                        echo '<form action="modifier_user.php" method="POST">';
                        echo '<div class="table-responsive">';
                        echo '<table  class="table table-hover">';

                        echo '<input type="hidden" name="idUser" value="' . $user['id'] . '">';

                        echo '<tr><td><div class="form-outline"><label for="nom">Nom :</label></td>';
                        echo '<td><input type="text" name="nom" value="' . $user['nom'] . '" class="formField"></td></tr></div>';


                        echo '<tr><td><div class="form-outline "><label for="prenom">Prénom :</label></td>';
                        echo '<td><textarea name="prenom" class="formField">' . $user['prenom'] . '</textarea></td></tr></div>';

                        echo '<tr><td><div class="form-outline"><label for="email">Email :</label></td>';
                        echo '<td><input type="text" name="email" value="' . $user['email'] . '"></td></tr></div>';

                        echo '<tr><td><div class="form-outline "><label for="mot_de_passe">Mot de passe :</label></td>';
                        echo '<td><input type="text" name="mot_de_passe" value="' . $user['mot_de_passe'] . '"></td></tr></div>';



                        echo '<tr><td><div class="form-outline "><label for="typeUser">Type utilisateur :</label></td>';
                        echo '<td><select name="typeUser" id="typeUser">';
                        echo '<option value="admin"' . ($user['typeUser'] === 'admin' ? ' selected' : '') . '>admin</option>';
                        echo '<option value="patient"' . ($user['typeUser'] === 'patient' ? ' selected' : '') . '>patient</option>';
                        echo '<option value="visiteur"' . ($user['typeUser'] === 'visiteur' ? ' selected' : '') . '>visiteur</option>';

                        echo '</select></td></tr></div>';




                        echo '</table>';
                        ?>

                    </div>

                </div>



                <!-- regimes -->



                <div class="col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                    <p class="fw-medium text-uppercase text-primary mb-2"></p>
                    <p class="display-5  about"></p>
                    <p class=""></p>

                    <!-- Première ligne affiche les regimes liés à la user-->
                    <div class="row">
                        <div class="col">
                            <?php
                            // Récupération des régimes associés à la user
                            $query = "SELECT regimes.* FROM regimes_users
            LEFT JOIN regimes ON regimes_users.idRegime = regimes.Id
            WHERE regimes_users.idUser = :idUser";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                            $stmt->execute();
                            $regimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Récupération de tous les régimes
                            $query = "SELECT * FROM regimes";
                            $stmt = $conn->query($query);
                            $tousRegimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Affichage des régimes avec cases à cocher

                            echo '<p class="fw-medium text-uppercase text-primary mb-2">Régimes associés</p>';
                            foreach ($tousRegimes as $regime) {
                                $checked = in_array($regime, $regimes) ? 'checked' : '';
                                echo '<input type="checkbox" name="regimes[]" value="' . $regime['Id'] . '" ' . $checked . '> ' . $regime['nom'] . '<br>';
                            }
                            ?>
                        </div>
                    </div>

                    <br><br>
                    <!-- Deuxième ligne affiche les allergies liées à la user-->
                    <div class="row">
                        <div class="col">


                            <?php
                            // Récupération des allergies associés à la user
                            $query = "SELECT allergies.* FROM allergies_users
            LEFT JOIN allergies ON allergies_users.idallergie = allergies.Id
            WHERE allergies_users.idUser = :idUser";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
                            $stmt->execute();
                            $allergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Récupération de tous les régimes
                            $query = "SELECT * FROM allergies";
                            $stmt = $conn->query($query);
                            $tousallergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Affichage des régimes avec cases à cocher
                            echo '<p class="fw-medium text-uppercase text-primary mb-2">allergies associées</p>';
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