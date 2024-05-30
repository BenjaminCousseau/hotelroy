<!DOCTYPE html>
<html lang="fr">
<?php include 'include/head.php'; ?>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <h2>Connexion</h2>
        <form action="loginphp.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>

    <div class="container">
        <h2>S'inscrire <A href="inscription.php">ici</A></h2>
        
    </div>



    <?php include 'include/footer.php'; ?>
</body>
</html>