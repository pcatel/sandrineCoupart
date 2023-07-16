<?php
session_start();

if ($_SESSION['email'] !== "") {
  $user = $_SESSION['email'];

  if (substr($_SESSION['email'], 0, 5) == "admin") {
    echo '<a href="http://pascalcatel.com/maquettes/quaiantique/admin/admin.php" class="right" title="Administrer le site">Administration aaaaa</a>';
  }
  
  echo '<a href="http://pascalcatel.com/maquettes/quaiantique/index.php?deconnexion=true" class="right" title="me déconnecter">' . $user . '</a>';







  // si déconnexion
  if (isset($_GET['deconnexion'])) {
    if ($_GET['deconnexion'] == true) {
      session_unset();
      header("location:connexion.php");
      exit(); // Ajout de cette ligne pour arrêter l'exécution du script PHP après la redirection
    }
  } else {
    echo '<a href="connexion.php" class="right active" id="loginLink">Me connecter</a>';
  }
  // fin deconnexion
} else {
  echo '<a href="connexion.php" class="right active" id="loginLink">Me connecter</a>';
}
?>