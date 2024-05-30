<!DOCTYPE html>
<html lang="fr">
<?php include 'include/head.php'; ?>
<body>
<?php include 'include/header.php'; ?>

<section id="accueil">
    <h2>Voici l'historique de vos réservations :</h2>
    <?php
    session_start();
    if(isset($_SESSION['username'])) {
        include 'include/connection.php';
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die("Erreur de connexion : " . $conn->connect_error);
        }

        $username = $_SESSION['username'];
        $sql = "SELECT * FROM historique WHERE user='$username' ORDER BY date DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th>Numéro de chambre</th><th>Date de réservation</th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['chambre'] . "</td><td>" . $row['date'] . "</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Aucune réservation trouvée.</p>";
        }



        $sql = "SELECT * FROM login WHERE user='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Affichage des données de l'utilisateur
                while($row = $result->fetch_assoc()) {
                    echo "<H3>Réservation Actuelle : " . $row["reservation"] . "</H3>";
                    echo "<p>Date: " . $row["date"] . "</p>";
                    // Vous pouvez ajouter d'autres champs de la table login que vous souhaitez afficher

                    echo "<form action='cancel_reservation.php' method='post'>";
                    echo "<button type='submit' class='btn btn-danger'>Résilier la réservation</button>";
                    echo "</form>";
                }
            } else {
                echo "Aucune donnée trouvée pour cet utilisateur.";
            }

        $conn->close();
    } else {
        // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
        header("Location: login.php");
        exit();
    }
    ?>
</section>

<?php include 'include/footer.php'; ?>
</body>
</html>