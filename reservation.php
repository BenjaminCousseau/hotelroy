<?php
// Vérifie si l'utilisateur est connecté
session_start();
if(isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['room_number'])) {
        include 'include/connection.php';
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        // Récupération des données de la chambre à réserver
        $room_number = $_POST['room_number'];
        $username = $_SESSION['username'];
        $reservation_date = date("Y-m-d"); // Date actuelle

        // Mise à jour de la disponibilité de la chambre dans la table 'chambres'
        $update_sql = "UPDATE chambres SET dispo=0 WHERE num='$room_number'";
        if ($conn->query($update_sql) === TRUE) {
            // Insertion de la réservation dans la table 'login'
            $insert_sql = "UPDATE login SET reservation='$room_number', date='$reservation_date' WHERE user='$username'";
            //---------------------------------------------------------------------------------------------------------------------------------------------------
            if ($conn->query($insert_sql) === TRUE) {
                // Insertion de l'historique de réservation
                $insert_historique_sql = "INSERT INTO historique (user, chambre, date) VALUES ('$username', '$room_number', '$reservation_date')";
                if ($conn->query($insert_historique_sql) === TRUE) {
            //---------------------------------------------------------------------------------------------------------------------------------------------------
                    echo "<div class='container'><p>Réservation réussie pour la chambre numéro $room_number.</p></div>";
                } else {
                    echo "Erreur lors de l'insertion dans l'historique: " . $conn->error;
                }
            } else {
                echo "Erreur lors de l'insertion de la réservation: " . $conn->error;
            }
        } else {
            echo "Erreur lors de la mise à jour de la disponibilité de la chambre: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "<div class='container'><p>Erreur: Aucune chambre sélectionnée pour la réservation.</p></div>";
    }
} else {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}
?>