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
            <h1 class="display-3 text-white animated slideInRight   SiteName1">Fiche recette</h1>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-2">


                </div>
                <?php include 'php/connect.php'; ?>

                <!-- recettes -->

                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.5s">


                    <?php

                    $idRecette = $_GET['id'];

                    // Connexion à la base de données
                    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);

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

                    // Vérification si l'utilisateur a déjà voté
                    $query = "SELECT * FROM notes_recettes WHERE idRecette = :idRecette AND idUser = :idUser";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
                    $stmt->bindParam(':idUser', $_SESSION['IdCpteUser'], PDO::PARAM_INT);
                    $stmt->execute();
                    $noteRow = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Variables pour stocker les valeurs de note et commentaire
                    $note = '';
                    $commentaire = '';

                    // Si l'utilisateur a déjà voté, récupérer les valeurs
                    if ($noteRow) {
                        $note = $noteRow['note'];
                        $commentaire = $noteRow['commentaire'];



                        
                    }

                    // Affichage du formulaire de modification de la recette

                    echo '<div class="table-responsive">';
                    echo '<table  class="table table-hover">';

                    echo '<input type="hidden" name="idRecette" value="' . $recette['Id'] . '">';

                    echo '<tr><td><div class="form-outline"><label for="titre">Titre :</label></td>';
                    echo '<td>' . $recette['titre'] . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="description">Description :</label></td>';
                    echo '<td>' . $recette['description'] . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline"><label for="temps_preparation">Temps de préparation :</label></td>';
                    echo '<td>' . $recette['temps_preparation'] . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="temps_repos">Temps de repos :</label></td>';
                    echo '<td>' . $recette['temps_repos'] . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="temps_cuisson">Temps de cuisson :</label></td>';
                    echo '<td>' . $recette['temps_cuisson'] . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="ingredients">Ingrédients :</label></td>';
                    echo '<td>' . nl2br($recette['ingredients']) . '</td></tr></div>';

                    echo '<tr><td><div class="form-outline "><label for="etapes">Étapes :</label></td>';
                    echo '<td>' . nl2br($recette['etapes']) . '</td></tr></div>';

                    echo '</table>';

                    ?>

                    <form id="ratingForm">
                        <input type="hidden" name="idRecette" id="idRecette" value="<?php echo $recette['Id']; ?>">
                        <input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['IdCpteUser']; ?>">

                        <div class="form-outline mb-4">
                            <label class="form-label" for="note">Note (de 1 à 5)</label>
                            <?php 
                            if ($noteRow) {
                                echo $note;}
                            else {

                                echo '<input  type="number" name="note" id="note" min="1" max="5" class="form-control" required">';}
                                
                                ?>
                            
                        </div>

                        <div class="form-outline mb-4">
                            <label class="form-label" for="commentaire">Commentaire</label>
                            <?php 
                            if ($noteRow) {
                                echo $commentaire;}
                           
                            else {
                                echo '<textarea  name="commentaire" id="commentaire" class="form-control" required></textarea>';}
                                ?>

                        </div>

                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>

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
                            echo '<p class="fw-medium text-uppercase text-primary mb-2">Régimes associés</p>';
                            foreach ($tousRegimes as $regime) {
                                $checked = in_array($regime, $regimes) ? 'checked' : '';
                                echo '<input type="checkbox" disabled readonly name="regimes[]" value="' . $regime['Id'] . '" ' . $checked . '> ' . $regime['nom'] . '<br>';
                            }
                            ?>
                        </div>
                    </div>

                    <br><br>
                    <!-- Deuxième ligne affiche les allergies liées à la recette-->
                    <div class="row">
                        <div class="col">
                            <?php
                            // Récupération des allergies associées à la recette
                            $query = "SELECT allergies.* FROM allergies_recettes
                                        LEFT JOIN allergies ON allergies_recettes.idallergie = allergies.Id
                                        WHERE allergies_recettes.idRecette = :idRecette";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':idRecette', $idRecette, PDO::PARAM_INT);
                            $stmt->execute();
                            $allergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Récupération de toutes les allergies
                            $query = "SELECT * FROM allergies";
                            $stmt = $conn->query($query);
                            $toutesAllergies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Affichage des allergies avec cases à cocher
                            echo '<p class="fw-medium text-uppercase text-primary mb-2">Allergies associées</p>';
                            foreach ($toutesAllergies as $allergie) {
                                $checked = in_array($allergie, $allergies) ? 'checked' : '';
                                echo '<input type="checkbox" disabled readonly name="allergies[]" value="' . $allergie['Id'] . '" ' . $checked . '> ' . $allergie['nom'] . '<br>';
                            }
                            ?>
                        </div>
                    </div>

                    <br><br>


                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <?php include 'php/footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="js/notation.js"></script>
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