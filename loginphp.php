<?php
session_start(); // Démarre la session PHP

include 'include/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Préparation de la requête SQL pour vérifier les informations de connexion
    $sql = "SELECT * FROM login WHERE user='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Récupération de la ligne de résultat
        $row = $result->fetch_assoc();
        // Vérification du mot de passe
        if (password_verify($password, $row['password'])) {
            // L'utilisateur est authentifié
            // Définition de la variable de session
            $_SESSION['username'] = $username;
            // Redirection vers la page compte.php
            header("Location: compte.php");
            exit(); // Assurez-vous de terminer le script après la redirection
        } else {
            echo "<div class='container'><p>Mot de passe incorrect.</p></div>";
        }
    } else {
        echo "<div class='container'><p>Nom d'utilisateur incorrect.</p></div>";
    }

    $conn->close();
}
?>