<!DOCTYPE html>
<html lang="fr">
<?php include 'include/head.php'; ?>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <h2>Chambres disponibles :</h2>
        <?php
        // Vérifie si l'utilisateur est connecté
        session_start();
        if(isset($_SESSION['username'])) {
            include 'include/connection.php';
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            if ($conn->connect_error) {
                die("Erreur de connexion : " . $conn->connect_error);
            }

            // Sélection des chambres disponibles
            $sql = "SELECT * FROM chambres WHERE dispo=1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Affichage des chambres disponibles
                while($row = $result->fetch_assoc()) {
                    echo "<p>Chambre numéro : " . $row["num"] . "</p>";
                    echo "<form action='reservation.php' method='post'>";
                    echo "<input type='hidden' name='room_number' value='" . $row["num"] . "'>";
                    echo "<button type='submit' class='btn btn-primary'>Réserver</button>";
                    echo "</form>";

                    
                }
            } else {
                echo "Aucune chambre disponible pour le moment.";
            }

            $conn->close();
        } else {
            // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
            echo "<p>Veuillez vous connecter pour réserver une chambre.</p>";
            echo "<a href='login.php' class='btn btn-primary'>Se connecter</a>";
        }
        ?>
    </div>

    <?php include 'include/footer.php'; ?>
</body>
</html>