<?php
session_start();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    $email = $_SESSION['email'];
    
    
    
    if ($_SESSION['typeUser'] === 'admin') {
        echo '<script>document.getElementById("seconnecter").innerHTML = \'<a href="admin.php" class="nav-item nav-link">' . $email . '</a>\';</script>';
       



       
    } else {
        echo '<script>document.getElementById("seconnecter").innerHTML = \'<a href="compteUser.php" class="nav-item nav-link">' . $email . '</a>\';</script>';
   

    }
}
?>
