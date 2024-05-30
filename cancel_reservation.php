<?php
// Vérifie si l'utilisateur est connecté
session_start();
if(isset($_SESSION['username'])) {
    include 'include/connection.php';
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Récupération du numéro de chambre réservée par l'utilisateur
    $username = $_SESSION['username'];
    $get_room_number_sql = "SELECT reservation FROM login WHERE user='$username'";
    $get_room_number_result = $conn->query($get_room_number_sql);

    if ($get_room_number_result->num_rows > 0) {
        $row = $get_room_number_result->fetch_assoc();
        $room_number = $row["reservation"];

        // Annulation de la réservation pour l'utilisateur connecté
        $cancel_reservation_sql = "UPDATE login SET reservation=NULL, date=NULL WHERE user='$username'";
        if ($conn->query($cancel_reservation_sql) === TRUE) {
            // Mise à jour de la disponibilité de la chambre dans la table 'chambres'
            $update_dispo_sql = "UPDATE chambres SET dispo=1 WHERE num='$room_number'";
            if ($conn->query($update_dispo_sql) === TRUE) {
                echo "<div class='container'><p>Réservation annulée avec succès.</p></div>";
            } else {
                echo "Erreur lors de la mise à jour de la disponibilité de la chambre : " . $conn->error;
            }
        } else {
            echo "Erreur lors de l'annulation de la réservation : " . $conn->error;
        }
    } else {
        echo "Aucune réservation trouvée pour cet utilisateur.";
    }

    $conn->close();
} else {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit(); // Assurez-vous de terminer le script après la redirection
}
?>