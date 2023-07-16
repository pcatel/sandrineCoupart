<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sandrine Coupart Diététicienne-Nutritionniste</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
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
            <h1 class="display-3 text-white animated slideInRight  SiteName1">Recettes</h1>

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

                    <p class="display-5 mb-4 about">J'ai sélectionné pour vous des recettes simples et rapides à réaliser. Ces recettes sont classées selon le type de régime.</p>
                    <p class="mb-4">Attention !!! en tant que patient, vous bénéficiez de recettes supplémentaires adaptées à vos régimes et tenant comptes de vos allergies eventuelles.
                    </p>

                    <div class="col-lg-12">
                        <div class="container">
                            
                        
                        <div class="row">
                                <div class="col">
                                 <!-- Liste des recettes par régimes  -->    
                                 <?php include 'php/connect.php';  ?>
                                 <?php include 'recettes/table_regimes.php';  ?>
                                </div>



                                <div class="col">
                            <!-- Liste des recettes par allergies -->    
                            <?php if ($_SESSION['typeUser'] === 'patient') {
                            include 'recettes/table_regimes_supp.php';  
                            }
                            ?>

                                
                                </div>
                            </div>
                        </div>







                    </div>


                </div>
            </div>
        </div>
        <!-- About End -->




        </div>



        

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