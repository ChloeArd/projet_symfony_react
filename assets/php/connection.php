<?php
use Model\DB;

require "../../../src/Model/DB.php";

if (isset($_POST["email"], $_POST["password"])) {
    $bdd = DB::getInstance();

    $mail = htmlentities(trim($_POST['email']));
    $pass = htmlentities(trim($_POST['password']));

    // I get the name of the user
    $stmt = $bdd->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(":email", $mail);
    $stmt->execute();

    $user = $stmt->fetch();
    if (password_verify($pass, $user['password'])) {
        // If the 2 password correspond then we open the session and we store the user's data in a session.
        session_start();

        $timeSession = 60 * 60 * 6; // session ends after 6 hours
        session_set_cookie_params($timeSession);

        $_SESSION['id'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['email'] = $mail;
        $_SESSION['password'] = $pass;
        $_SESSION['role_fk'] = $user['role_fk'];
        $id = $_SESSION['id'];

        header("Location: ../../index.php?success=0&message=Vous%20êtes%20connecté(e).");
    }
    else {
        header("Location: ../../index.php?controller=home&page=connection&error=0&message=Votre%20mot%20de%20passe%20ou%20votre%20email%20est%20incorrect.");
    }
}
else {
    header("Location: ../../index.php?controller=home&page=connection&error=1&message=Un%20des%20champs%20est%20vide.");
}