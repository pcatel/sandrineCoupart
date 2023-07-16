<?php
// traitement connexion et ajout BDD
include 'php/connect.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $mot_de_passe = $_POST['mot_de_passe'];
        $typeUser = $_POST['typeUser'];
        $regimes = isset($_POST['regimes']) ? $_POST['regimes'] : array();
        $allergies = isset($_POST['allergies']) ? $_POST['allergies'] : array();

        $query = "INSERT INTO users (nom, prenom, email, mot_de_passe, typeUser)
              VALUES (:nom, :prenom, :email, :mot_de_passe, :typeUser)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
        $stmt->bindParam(':typeUser', $typeUser, PDO::PARAM_STR);
        $stmt->execute();

        $idUser = $conn->lastInsertId();

        if (!empty($regimes)) {
            $query = "INSERT INTO regimes_users (idRegime, idUser) VALUES (:idRegime, :idUser)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            foreach ($regimes as $idRegime) {
                $stmt->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        if (!empty($allergies)) {
            $query = "INSERT INTO allergies_users (idAllergie, idUser) VALUES (:idAllergie, :idUser)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            foreach ($allergies as $idAllergie) {
                $stmt->bindParam(':idAllergie', $idAllergie, PDO::PARAM_INT);
                $stmt->execute();
            }
        }

        // Redirection vers index.php
        header('Location: admin.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
?>
