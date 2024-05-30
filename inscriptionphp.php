<?php
include 'include/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Vérification si le nom d'utilisateur existe déjà
    $check_username_query = "SELECT * FROM login WHERE user='$username'";
    $check_username_result = $conn->query($check_username_query);
    if ($check_username_result->num_rows > 0) {
        // Nom d'utilisateur déjà utilisé, afficher un message d'erreur
        echo "<div class='container'><p>Ce nom d'utilisateur est déjà pris.</p></div>";
    } else {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour l'insertion
        $sql = "INSERT INTO login (user, password) VALUES ('$username', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='container'><p>Inscription réussie !</p></div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>