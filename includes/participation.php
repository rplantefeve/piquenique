<?php

use Edu\Stmichel\Piquenique\Includes\DB;

require_once 'includes/DB.php';

function verifierExistenceParticipant($email)
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

function changerParticipation($email, $participation, $nbParticipants = '0')
{
    // requête qui met à jour les champs 'participation' et 'nbParticipants' du participant
    $requete = "UPDATE participant SET participation = :participation, nbParticipants = :nbParticipants WHERE mail = :email";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'email' => $email,
        'nbParticipants' => $nbParticipants,
        'participation' => $participation
    ));
}

function enregisterParticipation($nom, $prenom, $nomJeuneFille, $nbParticipants, $email, $section, $promotion, $participation)
{
    $promotion = strtoupper($promotion);
    // requête qui met à jour le champ 'participation' du participant
    $requete = "INSERT INTO participant (nom, prenom, nomAuBts, nbParticipants, mail, section, anneeSorti, participation)"
            . " VALUES (:nom, :prenom, :nomJeuneFille, :nbParticipants, :email, :section, :promotion, :participation)";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'nom' => $nom,
        'prenom' => $prenom,
        'nomJeuneFille' => $nomJeuneFille,
        'nbParticipants' => $nbParticipants,
        'email' => $email,
        'section' => $section,
        'promotion' => $promotion,
        'participation' => $participation
    ));
}
