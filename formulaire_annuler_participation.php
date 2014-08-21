<?php
require_once 'includes/participation.php';
require_once 'includes/utilisateur.php';

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
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST" && filter_input(INPUT_POST, 'submittedForm') === "unparticipateForm") {
    $formSubmitted = true;
    $email = filter_input(INPUT_POST, 'inputEmail', FILTER_SANITIZE_EMAIL);

    // On vérifie s'il existe en BDD
    if (verifierExistenceParticipant($email)) {
        // Désincription
        changerParticipation($email, "non");
        // Message, désinscription effectuée
        $messageDesinscriptionEffectuee = true;
    }
    // S'il n'existe pas en BDD
    else {
        // Message, l'adresse email n'existe pas
        $messageNonExistence = true;
    }
} elseif (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST" && filter_input(INPUT_POST, 'submittedForm') === "unparticipateFormAuthenticated") {
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    // Inscrire le participant (mise à jour)
    changerParticipation($email, "non");
    // Message, désinscription prise en compte
    $messageDesinscriptionEffectuee = true;
}

$title = "Pique-Nique : Annuler sa participation";
include_once 'includes/top.php';

// si l'utilisateur est loggué
if ($isAUserIsLogged) {
    $utilisateur = getCompleteInformationsByEmailAddress($_SESSION['user']);
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Ne plus participer au pique-nique</h3>
    </div>
    <div class="panel-body">
        <?php
        // Si personne de connecté
        if (!$isAUserIsLogged) {
            ?>
            <p>Veuillez remplir le formulaire ci-dessous afin d'annuler votre participation au pique-nique du 13 Septembre 2014.</p>
            <form id="formParticipation" name="formParticipation" class="form-horizontal" role="form" method="POST" action="formulaire_annuler_participation.php">
                <div id="div_inputEmail" class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div id="div_inputEmailFeedback" class="col-sm-4">
                        <input id="inputEmail" name="inputEmail" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="btnInscription" type="submit" class="btn btn-default">Annuler participation</button>
                        <input name="submittedForm" type="hidden" value="unparticipateForm"/>
                    </div>
                </div>
            </form>
            <?php
        }// fin si personne de connecté
        else {
            // si un utilisateur est connecté
            echo '<p>Bonjour ' . $utilisateur['civilite'] . ' ' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . ' , vous ';
            // si l'utilisateur ne participe pas
            if ($utilisateur['participation'] === "non") {
                echo "n'êtes pas inscrit(e) au pique-nique.</p>";
            }
            // l'utilisateur est inscrit au pique-nique
            else {
                echo "êtes inscrit(e) au pique nique. Si vous souhaitez vous désinscrire, il vous suffit de presser le bouton ci-dessous :</p>";
                ?>
                <form id="formParticipation" name="formParticipation" class="form-horizontal" role="form" method="POST" action="formulaire_annuler_participation.php">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="btnInscription" type="submit" class="btn btn-default">Annuler participation</button>
                            <input name="userEmail" type="hidden" value="<?= $utilisateur['mail'] ?>"/>
                            <input name="submittedForm" type="hidden" value="unparticipateFormAuthenticated"/>
                        </div>
                    </div>
                </form>
                <?php
            }
        }//fin sinon un utilisateur est connecté
        if ($messageDesinscriptionEffectuee) {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Dommage !</strong> Vous vous êtes désinscrit au pique-nique.
            </div>
            <?php
        } elseif ($messageNonExistence) {
            ?>
            <div class="alert alert-danger" role="alert">
                <strong>Attention !</strong> Cette adresse email n'existe pas. Vérifiez votre saisie.
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script src="js/verifs_formulaires_common.js"></script>
<script src="js/verifs_formulaires_annuler_participation.js"></script>
<?php include 'includes/bottom.php'; ?>
