<?php
require_once 'includes/inscription.php';
require_once 'includes/participation.php';
require_once 'includes/utilisateur.php';

// Initialisation des variables
$formSubmitted = false;

// Messages d'informations
$messageDesinscriptionEffectuee = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// Si le formulaire a été envoyé
if ($_SERVER['REQUEST_METHOD'] === "POST" && filter_input(INPUT_POST, 'submittedForm') === "unsubscribeForm") {
    $formSubmitted = true;
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);

    // suppression définitive du participant
    desinscrireParticipant($email);
    $messageDesinscriptionEffectuee = true;
    // logout de l'utilisateur
    session_start();
    session_destroy();
    $isAUserIsLogged = false;
}

$title = "Registre : Désinscription";
include_once 'includes/top.php';

// si l'utilisateur est loggué
if ($isAUserIsLogged && !($_SERVER['REQUEST_METHOD'] === "POST" && filter_input(INPUT_POST, 'submittedForm') === "unsubscribeForm")) {
    $utilisateur = getCompleteInformationsByEmailAddress($_SESSION['user']);
} else {
    $isAUserIsLogged = false;
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Désinscription du registre</h3>
    </div>
    <div class="panel-body">
        <?php
        if ($messageDesinscriptionEffectuee) {
            ?>
            <div class="alert alert-success" role="alert">
                <strong>Dommage !</strong> Vous n'êtes plus inscrit(e) dans le registre des anciens.
            </div>
            <?php
        }
        // Si personne de connecté
        if (!$isAUserIsLogged) {
            ?>
            <p>Seuls les utilisateurs authentifiés peuvent se désinscrire du registre des anciens.</p>

            <?php
        } // fin si personne de connecté
        else {
            // si un utilisateur est connecté
            echo '<p>Bonjour ' . $utilisateur['civilite'] . ' ' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . ' , vous faites partie du registre des anciens et nous vous en remercions.</p>';
            echo '<p>Si vous souhaitez vous désinscrire de ce registre, veuillez cocher la case ci-dessous puis appuyez sur le bouton ci-dessous :</p><br/>';
            ?>
            <form id="formInscription" action="formulaire_desinscription.php" method="POST" class="form-inline">
                <div id="div_inputChk" class="checkbox">
                    <label>
                        <input id="inputChk" name="inputChk" type="checkbox" onclick="enableButton()"/> Je souhaite me désinscrire
                    </label>
                </div>
                <button id="btnDesinscription" type="submit" class="btn btn-default disabled">Se désinscrire</button>
                <input name="userEmail" type="hidden" value="<?= $utilisateur['mail'] ?>"/>
                <input name="submittedForm" type="hidden" value="unsubscribeForm"/>
            </form>
            <br/>
            <p class="bg-danger"><strong>Attention !</strong> Cette action est irréversible.</p>
            <?php
        }
        ?>
    </div>
</div>
<script>
    /*
     * Fonctions de conditionnement d'affichage
     */

    // Activer le bouton de désinscription
    function enableButton()
    {
        var bouton = document.getElementById('btnDesinscription');
        // si le bouton est désactivé
        if (bouton.className.toString().indexOf('disabled') !== -1) {
            // activation du bouton
            bouton.className = "btn btn-default";
        }
        // sinon, il est désactivé
        else {
            // désactivation
            bouton.className = "btn btn-default disabled";
        }
    }
</script>
<?php include 'includes/bottom.php'; ?>
