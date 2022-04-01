<?php

use Model\DB;
require "../../../src/Model/DB.php";

if (isset($_POST["firstname"], $_POST['lastname'], $_POST["email"], $_POST["password"], $_POST['passwordR'])) {
    $bdd = DB::getInstance();

    $firstname = htmlentities(trim(ucfirst($_POST["firstname"])));
    $lastname = htmlentities(trim(ucfirst($_POST['lastname'])));
    $email = htmlentities(trim($_POST["email"]));
    $password = htmlentities(trim($_POST["password"]));
    $passwordR = htmlentities(trim($_POST['passwordR']));

    // I encrypt the password.
    $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

    $requete = $bdd->prepare("SELECT * FROM user WHERE email = :email");
    $requete->bindParam(":email", $email);
    $state = $requete->execute();

    if ($state) {
        $user = $requete->fetch();
        // Checks if email or pseudo is not in use.
        if ($user['email'] === $email) {
            header("Location: ../../index.php?controller=home&page=registration&error=0&message=L'email%20est%20déjà%20utilisé.");
        }
        // Check if the email address is valid.
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $maj = preg_match('@[A-Z]@', $password);
            $min = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);

            // Check if the 2 entered passwords are identical
            if ($password === $passwordR) {
                // Checks if the password contains upper case, lower case, number and at least 8 characters.
                if ($maj && $min && $number && strlen($password) >= 8) {
                    $lengthKey = 12;
                    $key = "";

                    // Create a key
                    for ($i = 1; $i < $lengthKey; $i++) {
                        $key.= mt_rand(0,9);
                    }

                    $sql = $bdd->prepare("INSERT INTO f07409276b_user (firstname, lastname, email, password, role_fk) 
                        VALUES (:firstname, :lastname, :email, :password, :role_fk)");

                    $sql->bindValue(':firstname', $firstname);
                    $sql->bindValue(':lastname', $lastname);
                    $sql->bindValue(':email', $email);
                    $sql->bindValue(':password', $encryptedPassword);
                    // People who register automatically have role 2 : user.
                    $sql->bindValue(':role_fk', 2);
                    $sql->execute();

                    header("Location: ../../index.php?controller=home&page=connection&success=0&message=Vous%20êtes%20inscrit(e)s.");
                }
                else {
                    header("Location: ../../index.php?controller=home&page=registration&error=2&message=%20mot%20de%20passe%20ne%20contient%20soit%20pas%20de%20minuscule,%20majuscule,%20chiffre%20ou%20est%20inférieur%20à%208%20caractères.");
                }
            }
            else {
                header("Location: ../../index.php?controller=home&page=registration&error=3&message=Les%20mots%20de%20passes%20ne%20correspondent%20pas.");
            }
        }
        else {
            header("Location: ../../View/registrationView.php?error=4&message=L'email%20est%20invalide.");
        }
    }
}
else {
    header("Location: ../../View/registrationView.php?error=5&message=Un%20des%20champs%20est%20vide.");
}