<?php
// Démarre la session
session_start();

// Détruit toutes les variables de session
$_SESSION = array();

// Détruit les cookies de sessions et autres parametres de sessions
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruit la session
session_destroy();

// Redirigez l'utilisateur vers la page de connexion
header("Location: login.php");
exit();
?>