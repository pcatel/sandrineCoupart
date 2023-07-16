<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top py-0 pe-5">
        <a href="index.html" class="navbar-brand ps-5 me-0">
            <h4 class="text-white m-0 SiteName">Sandrine Coupart : Diététicienne - Nutritionniste</h4>
           
        </a>


        <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Accueil</a>
                <a href="aPropos.php" class="nav-item nav-link">Qui suis-je ?</a>
                 
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Mes services</a>
                    <div class="dropdown-menu bg-light m-0">
                        <a href="consultations.php" class="dropdown-item">Consultations</a>
                        <a href="ateliersPrevention.php" class="dropdown-item">Ateliers prévention</a>
                        <a href="infosNutrition.php" class="dropdown-item">Infos nutrition</a>
                        <a href="temoignages.php" class="dropdown-item">Témoignages</a>
                        <a href="recettes.php" class="dropdown-item">Recettes</a>
                        

                    </div> 
                </div>
        
                <a href="contact.php" class="nav-item nav-link">Contact</a>
              
               
            </div>
            <a href="connexion.php" id= "seconnecter" class="btn btn-primary px-3 d-none d-lg-block">Se connecter</a>
            <?php include 'updateconnecter.php'; ?>    
        </div>
    </nav>
    <!-- Navbar End -->