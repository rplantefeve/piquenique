<?php
require_once 'includes/participation.php';

// Initialisation des variables
$formSubmitted = false;
$nom = null;
$prenom = null;
$email = null;
$nomJeuneFille = null;
// Messages d'informations
$messageDesinscriptionEffectuee = false;
$messageNonExistence = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// Si le formulaire a été envoyé 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $formSubmitted = true;
    $email = $_POST['inputEmail'];

    // On vérifie s'il existe en BDD
    if (verifyUser($email)) {
        // Désincription
        changerInscriptionParticipant($email, "non");
        // Message, désinscription effectuée
        $messageDesinscriptionEffectuee = true;
    }
    // S'il n'existe pas en BDD
    else {
        // Message, l'adresse email n'existe pas
        $messageNonExistence = true;
    }
}

$title = "Pique-Nique : Annuler sa participation";
include_once 'includes/top.php';



if (isset($_GET['num'])) {
    $choix = $_GET['num'];
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Ne plus participer au pique-nique</h3>
    </div>
    <div class="panel-body">
        <p>Veuillez remplir le formulaire ci-dessous afin d'annuler votre participation au pique-nique du 13 Septembre 2014.</p>
        <form id="formInscription" name="formInscription" class="form-horizontal" role="form" method="POST" action="formulaire_annuler_participation.php">
            <div id="div_inputEmail" class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div id="div_inputEmailFeedback" class="col-sm-4">
                    <input id="inputEmail" name="inputEmail" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnInscription" type="submit" class="btn btn-default">Annuler participation</button>
                </div>
            </div>
        </form>
        <?php
        if ($messageDesinscriptionEffectuee) {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Dommage !</strong> Vous vous êtes désinscrit au pique-nique.
            </div>
            <?php
        } else if ($messageNonExistence) {
            ?>
            <div class="alert alert-danger" role="alert">
                <strong>Attention !</strong> Cette adresse email n'existe pas. Vérifiez votre saisie.
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script src="js/verifs_formulaires_annuler_participation.js"></script>
<?php include 'includes/bottom.php'; ?>
