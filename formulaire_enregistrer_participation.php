<?php
require_once 'includes/participation.php';
require_once 'includes/utilisateur.php';

// Initialisation des variables
$formSubmitted = false;
$nom = null;
$prenom = null;
$email = null;
$nomJeuneFille = null;
$nbParticipants = null;
$section = null;
$promotion = null;
$sections = array(
    'none' => 'Sélectionnez une section',
    'SIO' => 'SIO',
    'IG' => 'IG',
    'IRIS' => 'IRIS',
    'PROJ' => 'Assistant de projet',
    'PROF' => 'Professeur'
);
// Messages d'informations
$messageInscriptionEffectuee = false;
$messageDejaInscrit = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// Si le formulaire a été envoyé
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST" && filter_input(INPUT_POST, 'submittedForm') === "participateForm") {
    $formSubmitted = true;

    $options = array(
        'inputLastName' => FILTER_SANITIZE_STRING,
        'inputFirstName' => FILTER_SANITIZE_STRING,
        'inputEmail' => FILTER_SANITIZE_EMAIL,
        'inputFamilyName' => FILTER_SANITIZE_STRING,
        'inputParticipantsNumber' => FILTER_SANITIZE_NUMBER_INT,
        'inputSection' => FILTER_SANITIZE_STRING,
        'inputPromotion' => FILTER_SANITIZE_NUMBER_INT
    );

    // On filtre les valeurs rentrées par l'utilisateur
    $resultat = filter_input_array(INPUT_POST, $options);

    // On récupère les valeurs filtrées
    $nom = $resultat['inputLastName'];
    $prenom = $resultat['inputFirstName'];
    $email = $resultat['inputEmail'];
    $nomJeuneFille = $resultat['inputFamilyName'];
    $nbParticipants = $resultat['inputParticipantsNumber'];
    $section = $resultat['inputSection'];
    $promotion = $resultat['inputPromotion'];

    // On vérifie s'il existe en BDD
    if (verifierExistenceParticipant($email)) {
        // Est-il déjà inscrit ?
        if (getParticipation($email)) {
            // Message, vous êtes déjà inscrit
            $messageDejaInscrit = true;
        } else {
            // Inscrire le participant (mise à jour)
            changerParticipation($email, "oui", $nbParticipants);
            // Message, inscription prise en compte
            $messageInscriptionEffectuee = true;
        }
    }
    // S'il n'existe pas en BDD
    else {
        // enregistrer et inscrire le participant
        enregisterParticipation($nom, $prenom, $nomJeuneFille, $nbParticipants, $email, $section, $promotion, 'oui');
        // Message, inscription prise en compte
        $messageInscriptionEffectuee = true;
    }
} elseif (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === "POST" && filter_input(INPUT_POST, 'submittedForm') === "participateFormAuthenticated") {
    $nbParticipants = filter_input(INPUT_POST, 'inputParticipantsNumber', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_EMAIL);
    // Inscrire le participant (mise à jour)
    changerParticipation($email, "oui", $nbParticipants);
    // Message, inscription prise en compte
    $messageInscriptionEffectuee = true;
}

$title = "Pique-Nique : Participation";
include_once 'includes/top.php';

// si l'utilisateur est loggué
if ($isAUserIsLogged) {
    $utilisateur = getCompleteInformationsByEmailAddress($_SESSION['user']);
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Participation au pique-nique</h3>
    </div>
    <div class="panel-body">
        <?php
        // Si personne de connecté
        if (!$isAUserIsLogged) {
            ?>
            <p>Veuillez remplir le formulaire ci-dessous afin de participer au pique-nique du 13 Septembre 2014 (Tous les champs sont obligatoires).</p>
            <form id="formParticipation" name="formParticipation" class="form-horizontal" role="form" method="POST" action="formulaire_enregistrer_participation.php">
                <div id="div_inputFirstName" class="form-group">
                    <label for="inputFirstName" class="col-sm-2 control-label">Prénom</label>
                    <div id="div_inputFirstNameFeedback" class="col-sm-4">
                        <input id="inputFirstName" name="inputFirstName" type="text" class="form-control"  placeholder="Prénom" value="<?= $prenom ?>"/>
                    </div>
                </div>
                <div id="div_inputLastName" class="form-group">
                    <label for="inputLastName" class="col-sm-2 control-label">Nom</label>
                    <div id="div_inputLastNameFeedback" class="col-sm-4">
                        <input id="inputLastName" name="inputLastName" type="text" class="form-control" placeholder="Nom" value="<?= $nom ?>"/>
                    </div>
                </div>
                <div id="div_buttonFamilyName" class="form-group<?php
                if ($formSubmitted && $nomJeuneFille != "") {
                    echo ' hidden';
                }
                ?>">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-info btn-group-sm" onclick="afficherNomJeuneFille();">Mariée ? Cliquez ici</button>
                    </div>
                </div>
                <div id="div_inputFamilyName" class="form-group<?php
                if (!$formSubmitted || $nomJeuneFille == "") {
                    echo ' hidden';
                }
                ?>">
                    <label for="inputFamilyName" class="col-sm-2 control-label">Nom de jeune fille</label>
                    <div class="col-sm-4">
                        <input id="inputFamilyName" name="inputFamilyName" type="text" class="form-control" placeholder="Nom de jeune fille" value="<?= $nomJeuneFille ?>"/>
                    </div>
                </div>
                <div id="div_inputParticipantsNumber" class="form-group">
                    <label for="inputParticipantsNumber" class="col-sm-2 control-label">Nombre de participants</label>
                    <div id="div_inputParticipantsNumberFeedback" class="col-sm-4">
                        <input id="inputParticipantsNumber" name="inputParticipantsNumber" type="text" class="form-control" placeholder="Nombre de participants (en incluant vous)" value="<?= $nbParticipants ?>"/>
                    </div>
                </div>
                <div id="div_inputEmail" class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div id="div_inputEmailFeedback" class="col-sm-4">
                        <input id="inputEmail" name="inputEmail" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                    </div>
                </div>
                <div id="div_inputSection" class="form-group">
                    <label for="inputSection" class="col-sm-2 control-label">Section</label>
                    <div id="div_inputSectionFeedback" class="col-sm-4">
                        <select id="inputSection" name="inputSection" class="form-control">
                            <?php
                            foreach ($sections as $key => $value) {
                                echo '<option ';
                                if ($section == $key) {
                                    echo 'selected';
                                }
                                echo ' value="' . $key . '">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="div_inputPromotion" class="form-group">
                    <label for="inputPromotion" class="col-sm-2 control-label">Année de promotion</label>
                    <div id="div_inputPromotionFeedback" class="col-sm-4">
                        <input id="inputPromotion" name="inputPromotion" type="text" class="form-control" placeholder="Année de promotion : N/A si non applicable" value="<?= $promotion ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="btnInscription" type="submit" class="btn btn-default">Participer</button>
                        <input name="submittedForm" type="hidden" value="participateForm"/>
                    </div>
                </div>
            </form>
            <?php
        }// fin si personne de connecté
        else {
            // si un utilisateur est connecté
            echo '<p>Bonjour ' . $utilisateur['civilite'] . ' ' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . ' , vous ';
            // si l'utilisateur participe déjà
            if ($utilisateur['participation'] === "oui") {
                echo "êtes déjà inscrit(e) au pique-nique.</p>";
            }
            // l'utilisateur n'est pas inscrit au pique-nique
            else {
                echo "n'êtes pas inscrit(e) au pique nique. Si vous souhaitez vous inscrire, il vous suffit de presser le bouton ci-dessous :</p>";
                ?>
                <form id="formParticipation2" name="formParticipation2" class="form-horizontal" role="form" method="POST" action="formulaire_enregistrer_participation.php">
                    <div id="div_inputParticipantsNumber" class="form-group">
                        <label for="inputParticipantsNumber" class="col-sm-2 control-label">Nombre de participants</label>
                        <div id="div_inputParticipantsNumberFeedback" class="col-sm-4">
                            <input id="inputParticipantsNumber" name="inputParticipantsNumber" type="text" class="form-control" placeholder="Nombre de participants (en incluant vous)" value="<?= $nbParticipants ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="btnInscription" type="submit" class="btn btn-default">Participer</button>
                            <input name="userEmail" type="hidden" value="<?= $utilisateur['mail'] ?>"/>
                            <input name="submittedForm" type="hidden" value="participateFormAuthenticated"/>
                        </div>
                    </div>
                </form>
                <?php
            }
        }//fin sinon un utilisateur est connecté
        if ($messageInscriptionEffectuee) {
            ?>
            <div class="alert alert-success" role="alert">
                <strong>Bravo !</strong> Inscription au pique-nique effectuée.<?php
                if (!$isAUserIsLogged) {
                    ?><br/>
                    Pourquoi pas s'inscrire au registre des anciens dans la foulée ? <a class="alert-link" href="formulaire_inscription.php?action=MAJ&nom=<?= htmlentities($nom) ?>&nomJeuneFille=<?= htmlentities($nomJeuneFille) ?>&prenom=<?= htmlentities($prenom) ?>&email=<?= htmlentities($email) ?>&section=<?= htmlentities($section) ?>&promotion=<?= htmlentities($promotion) ?>">Par ici !</a>
                <?php } ?>
            </div>
            <?php
        } elseif ($messageDejaInscrit) {
            ?>
            <div class="alert alert-warning" role="alert">
                <strong>Attention !</strong> Vous êtes déjà inscrit au pique-nique.
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script src="js/verifs_formulaires_common.js"></script>
<script src="js/verifs_formulaires_participation.js"></script>
<?php include 'includes/bottom.php'; ?>
