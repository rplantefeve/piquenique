<?php
require_once 'includes/participation.php';

// Initialisation des variables
$formSubmitted = false;
$nom = null;
$prenom = null;
$email = null;
$nomJeuneFille = null;
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
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $formSubmitted = true;
    $nom = $_POST['inputLastName'];
    $prenom = $_POST['inputFirstName'];
    $email = $_POST['inputEmail'];
    $nomJeuneFille = $_POST['inputFamilyName'];
    $section = $_POST['inputSection'];
    $promotion = $_POST['inputPromotion'];

    // On vérifie s'il existe en BDD
    if (verifyUser($email)) {
        // Est-il déjà inscrit ?
        if (getParticipation($email)) {
            // Message, vous êtes déjà inscrit
            $messageDejaInscrit = true;
        } else {
            // Inscrire le participant (mise à jour)
            changerInscriptionParticipant($email, "oui");
            // Message, inscription prise en compte
            $messageInscriptionEffectuee = true;
        }
    }
    // S'il n'existe pas en BDD
    else {
        // enregistrer et inscrire le participant
        enregisterInscrireParticipant($nom, $prenom, $nomJeuneFille, $email, $section, $promotion, 'oui');
        // Message, inscription prise en compte
        $messageInscriptionEffectuee = true;
    }
}

$title = "Pique-Nique : Participation";
include_once 'includes/top.php';



if (isset($_GET['num'])) {
    $choix = $_GET['num'];
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Participation au pique-nique</h3>
    </div>
    <div class="panel-body">
        <p>Veuillez remplir le formulaire ci-dessous afin de participer au pique-nique du 13 Septembre 2014.</p>
        <form id="formInscription" name="formInscription" class="form-horizontal" role="form" method="POST" action="formulaire_enregistrer_participation.php">
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
                    <input id="inputPromotion" name="inputPromotion" type="text" class="form-control" placeholder="Année de promotion" value="<?= $promotion ?>"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnInscription" type="submit" class="btn btn-default">S'inscrire</button>
                </div>
            </div>
        </form>
        <?php
        if ($messageInscriptionEffectuee) {
            ?>
            <div class="alert alert-success" role="alert">
                <strong>Bravo !</strong> Inscription au pique-nique effectuée.
            </div>
            <?php
        } else if ($messageDejaInscrit) {
            ?>
            <div class="alert alert-warning" role="alert">
                <strong>Attention !</strong> Vous êtes déjà inscrit au pique-nique.
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script src="js/verifs_formulaires_participation.js"></script>
<?php include 'includes/bottom.php'; ?>
