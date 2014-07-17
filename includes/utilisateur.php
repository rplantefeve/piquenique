<?php

use Edu\Stmichel\Piquenique\Includes\DB;

require_once 'includes/DB.php';

function logout()
{
    session_destroy();
    header('Location: index.php');
    exit;
}

function verifyUserCredentials($email, $password)
{
    // création de la requête à la BDD
    $requete = "SELECT 1 FROM participant WHERE mail = :email AND password = :password";
    // on prépare la requête
    $statement = DB::getInstance()->query($requete, array(
        'email' => $email,
        'password' => $password));
    // on retourne le résultat (retour false si pas de résultat)
    return $statement->fetch();
}

function isAUserIsLogged(&$areCredentialsOK = true)
{
    // si l'utilisateur est déjà authentifié
    if (\array_key_exists("user", $_SESSION)) {
        // s'il y a demande de déconnexion
        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === "POST" && $_POST['submittedForm'] === "disconnectionForm") {
            logout();
        }
        return true;
        // Sinon (pas d'utilisateur authentifié pour l'instant)
    } else {
        // si la méthode POST a été employée
        if (\filter_input(\INPUT_SERVER, 'REQUEST_METHOD') === "POST" && $_POST['submittedForm'] === "connectionForm") {
            // On vérifie l'existence de l'utilisateur
            $email = filter_input(\INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = \filter_input(\INPUT_POST, 'password');
            $loginSuccess = verifyUserCredentials($email, $password);
            // si l'utilisateur a été trouvé en BDD
            if ($loginSuccess) {
                // on enregistre l'utilisateur
                $_SESSION['user'] = $email;
                return true;
            } else {
                $areCredentialsOK = false;
                // si on arrive là, mauvaises informations de connexion
                return false;
            }
        }
        // sinon, pas de formulaire soumis ou ce n'est pas le formulaire de connexion
        else {
            return false;
        }
    }
}

function getCompleteInformationsByEmailAddress($utilisateur)
{
    // on construit la requête qui va tout récupérer
    $requete = "SELECT * FROM participant "
            . "WHERE mail = :email";

    // on extrait le résultat de la BDD sous forme de tableau associatif
    $resultat = DB::getInstance()->extraire1xN($requete, array(
        'email' => $utilisateur));

    // on retourne le résultat
    return $resultat;
}
