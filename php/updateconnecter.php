<?php
session_start();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    $email = $_SESSION['email'];
    
    
    if ($_SESSION['typeUser'] === 'admin') {
        echo '<script>document.getElementById("seconnecter").innerHTML = \'<a href="admin.php" class="btn btn-primary px-3 d-none d-lg-block">' . $email . '</a>\';</script>';
    } else {
        echo '<script>document.getElementById("seconnecter").innerHTML = \'<a href="compteUser.php" class="btn btn-primary px-3 d-none d-lg-block">' . $email . '</a>\';</script>';
    }
}
?>
