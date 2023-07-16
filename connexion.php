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

    <?php //include 'php/session.php'; ?>



    <?php include 'php/navbar.php'; ?>


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-3 text-white animated slideInRight   SiteName1">Se connecter</h1>

        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">


            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">


                    <p class="mb-4">Lors de la première consultation, vous avez reçu vos identifiants vous permettant de vous connecter et ainsi de bénéficier de recettes adaptées à votre régime.</p>

                    <p class="mb-4">Vous pouvez également retrouver les recettes santé disponibles <a href="recettes.php">ici</a></p>

                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <form action="verifUsers.php" method="POST">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label">Email</label>
                            <input type="text"  name="email" required class="form-control">
                        </div>

                        <!-- Password input -->



                        <div class="form-outline mb-4">
                            <label class="form-label">Mot de passe</label>
                            <input type="password"  name="password" required class="form-control">

                        </div>

                        <!-- 2 column grid layout for inline styling -->
                        <div class="row mb-4">


                            <div class="col">
                                <!-- Simple link -->
                                <a href="#!">Mot de passe oublié ?</a>
                            </div>
                        </div>

                        <!-- Submit button -->
                      
                        <input type="submit" class="btn btn-primary btn-block mb-4" id='submit' value='Me connecter'>
                        <?php
                        if (isset($_GET['erreur'])) {
                           $err = $_GET['erreur'];
                            if ($err == 1 || $err == 2)
                                echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                        }
                        ?>
                        <!-- Register buttons -->

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


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