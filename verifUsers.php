<?php
session_start();

// Récupérer les valeurs du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Effectuer la vérification de l'e-mail et du mot de passe dans la base de données
// Vous devez configurer la connexion à votre base de données MySQL ici
include 'php/connect.php';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);

    // Préparer et exécuter la requête
    $query = "SELECT * FROM users WHERE email = :email AND mot_de_passe = :password";
    $statement = $db->prepare($query);
    $statement->execute(array(':email' => $email, ':password' => $password));

    // Vérifier si l'utilisateur existe dans la base de données
    if ($row = $statement->fetch()) {
        // L'utilisateur est valide, créer une session
        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['typeUser'] = $row['typeUser'];
        $_SESSION['IdCpteUser'] = $row['id'];
      
    } else {
        // L'utilisateur n'est pas valide, rediriger avec un paramètre d'erreur
        header("Location: connexion.php?erreur=1");
        exit();
    }

    // Rediriger vers la page souhaitée après la connexion réussie
    header("Location: index.php"); // Remplacez "index.php" par la page souhaitée
    exit();
} catch (PDOException $e) {
    // Gérer les erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}
?>
