<?php

use Edu\Stmichel\Piquenique\Includes\DB;

require_once 'includes/DB.php';
function verifyUser($nom, $prenom, $email)
{
    // création de la requête à la BDD
    $requete = "SELECT 1 FROM participant WHERE nom = :nom AND prenom = :prenom AND mail = :email";
    // on exécute la requête
    $statement = DB::getInstance()->query($requete, array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email));
    // on retourne le résultat (retour false si pas de résultat)
    return $statement->fetch();
}

function getParticipation($email)
{
    // requête qui récupère la valeur du champ participation du participant
    $requete = "SELECT participation FROM participant WHERE mail = :email";
    // exécution de la requête
    $resultat = DB::getInstance()->extraire1xN($requete, array(
        'email' => $email));
    // Si le participant est inscrit
    if ($resultat['participation'] == "oui") {
        return true;
    } else {
        return false;
    }
}

function changerInscriptionParticipant($email, $participation)
{
    // requête qui met à jour le champ 'participation' du participant
    $requete = "UPDATE participant SET participation = :participation WHERE mail = :email";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'email' => $email,
        'participation' => $participation
    ));
}

function enregisterInscrireParticipant($nom, $prenom, $email, $participation)
{
    // requête qui met à jour le champ 'participation' du participant
    $requete = "INSERT INTO participant (nom, prenom, mail, participation) VALUES (:nom, :prenom, :email, :participation)";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'participation' => $participation
    ));
}
