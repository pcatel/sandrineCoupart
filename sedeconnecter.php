
<?php
session_start();

// Vérifier si l'utilisateur a cliqué sur le lien "Se déconnecter"
if (isset($_GET['logout'])) {
    // Détruire toutes les données de la session
    session_destroy();

    // Rediriger vers la page index.php
    header("Location: index.php");
    exit();
}
?>