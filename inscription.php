<!DOCTYPE html>
<html lang="fr">
<?php include 'include/head.php'; ?>
<body>
    <?php include 'include/header.php'; ?>

    <div class="container">
        <h2>Inscription</h2>
        <form action="inscriptionphp.php" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
    

    <?php include 'include/footer.php'; ?>
</body>
</html>