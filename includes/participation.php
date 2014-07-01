<?php

use Edu\Stmichel\Piquenique\Includes\DB;

require_once 'includes/DB.php';
function verifyUser($email)
{
    // création de la requête à la BDD
    $requete = "SELECT 1 FROM participant WHERE mail = :email";
    // on exécute la requête
    $statement = DB::getInstance()->query($requete, array(
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

function enregisterInscrireParticipant($nom, $prenom, $nomJeuneFille, $email, $section, $participation)
{
    // requête qui met à jour le champ 'participation' du participant
    $requete = "INSERT INTO participant (nom, prenom, nomAuBts, mail, section, participation)"
            ." VALUES (:nom, :prenom, :nomJeuneFille, :email, :section, :participation)";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'nom' => $nom,
        'prenom' => $prenom,
        'nomJeuneFille' => $nomJeuneFille,
        'email' => $email,
        'section' => $section,
        'participation' => $participation
    ));
}
