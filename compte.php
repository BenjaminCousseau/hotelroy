<!DOCTYPE html>
<html lang="fr">
<?php include 'include/head.php'; ?>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <h2>Mon Compte :</h2>
        <?php
        session_start(); // Démarre la session PHP

        // Vérifie si l'utilisateur est connecté
        if(isset($_SESSION['username'])) {
            // Récupération des informations de l'utilisateur connecté depuis la base de données
            include 'include/connection.php';
            $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Erreur de connexion : " . $conn->connect_error);
            }

            // Préparation de la requête SQL pour récupérer les données de l'utilisateur
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM login WHERE user='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Affichage des données de l'utilisateur
                while($row = $result->fetch_assoc()) {

                    echo "<p>Nom d'utilisateur: " . $row["user"] . "</p>";
                    echo "<p>Réservation: " . $row["reservation"] . "</p>";
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

            // Bouton de déconnexion
            echo "<form action='logout.php' method='post'>";
            echo "<button type='submit' class='btn btn-danger'>Se déconnecter</button>";
            echo "</form>";
        } else {
            // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
            header("Location: login.php");
            exit(); // Assurez-vous de terminer le script après la redirection
        }
        ?>
    </div>

    <?php include 'include/footer.php'; ?>
</body>
</html>