<?php

use Edu\Stmichel\Piquenique\classe\PDO2;

require_once 'config/config.inc.php';
require_once 'classe/PDO2.php';

try {
    $bdd = PDO2::getInstance();
} catch (Exception $e) {
    die('Erreur:' . $e->getMessage());
}

$sexe = $_POST['sexe'];
$nom = addslashes($_POST['nom']);
$nomAuBts = addslashes($_POST['nomAuBts']);
$prenom = addslashes($_POST['prenom']);
$mail = $_POST['mail1'];
$password = addslashes($_POST['password1']);
$section = $_POST['section'];
$anneeSorti = $_POST['anneeSorti'];
$participation = null;
$fonction = addslashes($_POST['fonction']);
$nomEise = addslashes($_POST['nomEise']);
$adresseEise1 = addslashes($_POST['adresseEise1']);
$adresseEise2 = addslashes($_POST['adresseEise2']);
$codePostal = $_POST['codePostalEise'];
$ville = addslashes($_POST['villeEise']);


$sql = "INSERT INTO  `piquenique`.`participant`
                    (`sexe` ,
                    `nom` ,
                    `nomAuBts` ,
                    `prenom` ,
                    `mail` ,
                    `password` ,
                    `section` ,
                    `anneeSorti` ,
                    `participation` ,
                    `fonction` ,
                    `nomEise` ,
                    `adresseEise1` ,
                    `adresseEise2` ,
                    `codePostal` ,
                    `ville`)
                VALUES
                    ('$sexe',
                    '$nom',
                    '$nomAuBts',
                    '$prenom',
                    '$mail',
                    '$password',
                    '$section',
                    '$anneeSorti',
                    '$participation',
                    '$fonction',
                    '$nomEise',
                    '$adresseEise1',
                    '$adresseEise2',
                    '$codePostal',
                    '$ville');";

$req = $bdd->query($sql);
//Si la participation est égale à oui.
?>
<p>
    Merci de votre inscription.
    Vous allez &ecirc;tre redirig&eacute; vers la page d'accueil.
</p>

<!--Redirection vers la page d'acueil.-->
<meta http-equiv="refresh" content="3; URL=index.php">
