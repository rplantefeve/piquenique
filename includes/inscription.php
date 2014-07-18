<?php

use Edu\Stmichel\Piquenique\Includes\DB;

require_once 'includes/DB.php';

function inscrireParticipant($civilite, $nom, $prenom, $email, $nomJeuneFille, $password, $section, $promotion, $firmName, $function, $address1, $address2, $zipCode, $city)
{
    // requête qui va enregistrer l'utilisateur (participant)
    $requete = "INSERT INTO participant (civilite, nom, prenom, mail, nomAuBts, password, section, anneeSorti, participation, nomEise, fonction, adresseEise1, adresseEise2, codePostal, ville)"
            . " VALUES (:civilite, :nom, :prenom, :email, :nomJeuneFille, :password, :section, :promotion, :participation, :firmName, :function, :address1, :address2, :zipCode, :city)";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'civilite' => $civilite,
        'nom' => $nom,
        'prenom' => $prenom,
        'nomJeuneFille' => $nomJeuneFille,
        'email' => $email,
        'password' => $password,
        'section' => $section,
        'promotion' => $promotion,
        'participation' => 'non',
        'firmName' => $firmName,
        'function' => $function,
        'address1' => $address1,
        'address2' => $address2,
        'zipCode' => $zipCode,
        'city' => $city
    ));
}

function mettreAJourInscrit($email, $firmName, $function, $address1, $address2, $zipCode, $city)
{
    // requête qui va enregistrer l'utilisateur (participant)
    $requete = "UPDATE participant SET "
            . "nomEise = :firmName, "
            . "fonction = :function, "
            . "adresseEise1 = :address1, "
            . "adresseEise2 = :address2, "
            . "codePostal = :zipCode, "
            . "ville = :city"
            . " WHERE mail = :email";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'email' => $email,
        'firmName' => $firmName,
        'function' => $function,
        'address1' => $address1,
        'address2' => $address2,
        'zipCode' => $zipCode,
        'city' => $city
    ));
}

function mettreAJourParticipant($email, $civility, $password, $firmName, $function, $address1, $address2, $zipCode, $city)
{
    // requête qui va enregistrer l'utilisateur (participant)
    $requete = "UPDATE participant SET "
            . "civilite = :civility, "
            . "password = :password, "
            . "nomEise = :firmName, "
            . "fonction = :function, "
            . "adresseEise1 = :address1, "
            . "adresseEise2 = :address2, "
            . "codePostal = :zipCode, "
            . "ville = :city"
            . " WHERE mail = :email";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'email' => $email,
        'civility' => $civility,
        'password' => $password,
        'firmName' => $firmName,
        'function' => $function,
        'address1' => $address1,
        'address2' => $address2,
        'zipCode' => $zipCode,
        'city' => $city
    ));
}

function desinscrireParticipant($email)
{
    // requête qui va supprimer l'utilisateur (participant)
    $requete = "DELETE FROM participant"
            . " WHERE mail = :email";
    // exécution de la requête
    DB::getInstance()->query($requete, array(
        'email' => $email
    ));
}
