<?php
require_once 'includes/participation.php';

// Initialisation des variables
$formSubmitted = false;
$civility = null;
$civilities = array(
    'none' => ' ',
    'M.' => 'M.',
    'Mlle' => 'Mlle',
    'Mme' => 'Mme'
);
$nom = null;
$prenom = null;
$email = null;
$emailConfirm = null;
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
$function = null;
$firmName = null;
$address1 = null;
$address2 = null;
$zipCode = null;
$city = null;

// Messages d'informations
$messageInscriptionEffectuee = false;
$messageDejaInscrit = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// Si le formulaire a été envoyé 
if ($_SERVER['REQUEST_METHOD'] === "POST" && $_POST['submittedForm'] === "subscribeForm") {
    $formSubmitted = true;
    $civility = $_POST['inputCivility'];
    $nom = $_POST['inputLastName'];
    $prenom = $_POST['inputFirstName'];
    $email = $_POST['inputEmail'];
    $nomJeuneFille = $_POST['inputFamilyName'];
    $password = $_POST['inputPassword'];
    $section = $_POST['inputSection'];
    $promotion = $_POST['inputPromotion'];
    $firmName = $_POST['inputFirmName'];
    $function = $_POST['inputFunction'];
    $address1 = $_POST['inputAddress1'];
    $address2 = $_POST['inputAddress2'];
    $zipCode = $_POST['inputZipCode'];
    $city = $_POST['inputCity'];

    // On vérifie l'existence de l'utilisateur
    if (verifierExistenceParticipant($email)) {
        $messageDejaInscrit = true;
    }
    // sinon, on créé l'utilisateur
    else {
        // création et inscription au registre
        inscrireParticipant($civility, $nom, $prenom, $email, $nomJeuneFille, $password, $section, $promotion, $firmName, $function, $address1, $address2, $zipCode, $city);
        $messageInscriptionEffectuee = true;
        // authentification automatique de l'utilisateur
        session_start();
        $_SESSION['user'] = $email;
    }
}


$title = "Registre : Inscription";
include_once 'includes/top.php';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inscription au registre</h3>
    </div>
    <div class="panel-body">
<?php
if ($messageInscriptionEffectuee) {
    ?>
            <div class="alert alert-success" role="alert">
                <strong>Bravo !</strong> Inscription au registre des anciens effectuée.
            </div>
    <?php
} else if ($messageDejaInscrit) {
    ?>
            <div class="alert alert-danger" role="alert">
                <strong>Attention !</strong> Cet utilisateur est déjà enregistré.
            </div>
    <?php
}
?>
        <p>Veuillez remplir le formulaire ci-dessous afin de vous inscrire au registre.</p>

        <p><strong>Note :</strong> L'inscription au registre des anciens entraîne une création de compte utilisateur afin de vous permettre de vous désinscrire si besoin.</p>
        <p>
            * champs obligatoires
        </p>
        <form id="formInscription" action="formulaire_inscription.php" method="POST" class="form-horizontal">
            <fieldset>
                <legend class="text-muted">Coordonnées</legend>
                <div id="div_inputCivility" class="form-group">
                    <label for="inputCivility" class="col-sm-2 control-label">Civilité *</label>
                    <div id="div_inputCivilityFeedback" class="col-sm-2">
                        <select id="inputCivility" name="inputCivility" class="form-control">
<?php
foreach ($civilities as $key => $value) {
    echo '<option ';
    if ($civility == $key) {
        echo 'selected';
    }
    echo ' value="' . $key . '">' . $value . '</option>';
}
?>
                        </select>
                    </div>
                </div>
                <div id="div_inputFirstName" class="form-group">
                    <label for="inputFirstName" class="col-sm-2 control-label">Prénom *</label>
                    <div id="div_inputFirstNameFeedback" class="col-sm-4">
                        <input id="inputFirstName" name="inputFirstName" type="text" class="form-control"  placeholder="Prénom" value="<?= $prenom ?>"/>
                    </div>
                </div>
                <div id="div_inputLastName" class="form-group">
                    <label for="inputLastName" class="col-sm-2 control-label">Nom *</label>
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
                    <label for="inputEmail" class="col-sm-2 control-label">Email *</label>
                    <div id="div_inputEmailFeedback" class="col-sm-4">
                        <input id="inputEmail" name="inputEmail" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                    </div>
                </div>
                <div id="div_inputEmailConfirm" class="form-group">
                    <label for="inputEmailConfirm" class="col-sm-2 control-label">Confirmer l'email *</label>
                    <div id="div_inputEmailConfirmFeedback" class="col-sm-4">
                        <input id="inputEmailConfirm" name="inputEmailConfirm" type="email" class="form-control" autocomplete="off" placeholder="pseudonyme@domaine.fr" value="<?= $emailConfirm ?>"/>
                    </div>
                </div>
                <div id="div_inputPassword" class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Mot de passe *</label>
                    <div id="div_inputPasswordFeedback" class="col-sm-4">
                        <input id="inputPassword" name="inputPassword" type="password" class="form-control"/>
                    </div>
                </div>
                <div id="div_inputPasswordConfirm" class="form-group">
                    <label for="inputPasswordConfirm" class="col-sm-2 control-label">Confirmation du mot de passe *</label>
                    <div id="div_inputPasswordConfirmFeedback" class="col-sm-4">
                        <input id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" class="form-control"/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-muted">Informations utiles</legend>
                <div id="div_inputSection" class="form-group">
                    <label for="inputSection" class="col-sm-2 control-label">Section *</label>
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
                    <label for="inputPromotion" class="col-sm-2 control-label">Année de promotion *</label>
                    <div id="div_inputPromotionFeedback" class="col-sm-4">
                        <input id="inputPromotion" name="inputPromotion" type="text" class="form-control" placeholder="Année de promotion : N/A si non applicable" value="<?= $promotion ?>"/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-muted">Entreprise</legend>
                <div id="div_inputFunction" class="form-group">
                    <label for="inputFunction" class="col-sm-2 control-label">Fonction dans l'entreprise</label>
                    <div class="col-sm-4">
                        <input id="inputFunction" name="inputFunction" type="text" class="form-control" placeholder="Fonction dans l'entreprise" value="<?= $function ?>"/>
                    </div>
                </div>
                <div id="div_inputFirmName" class="form-group">
                    <label for="inputFirmName" class="col-sm-2 control-label">Nom de l'entreprise</label>
                    <div class="col-sm-4">
                        <input id="inputFirmName" name="inputFirmName" type="text" class="form-control" placeholder="Nom de l'entreprise" value="<?= $firmName ?>"/>
                    </div>
                </div>
                <div id="div_inputAddress1" class="form-group">
                    <label for="inputAddress1" class="col-sm-2 control-label">Adresse</label>
                    <div class="col-sm-4">
                        <input id="inputAddress1" name="inputAddress1" type="text" class="form-control" placeholder="Adresse" value="<?= $address1 ?>"/>
                    </div>
                </div>
                <div id="div_inputAddress2" class="form-group">
                    <label for="inputAddress2" class="col-sm-2 control-label">Complément d'adresse</label>
                    <div class="col-sm-4">
                        <input id="inputAddress2" name="inputAddress2" type="text" class="form-control" placeholder="Complément d'adresse" value="<?= $address2 ?>"/>
                    </div>
                </div>
                <div id="div_inputZipCode" class="form-group">
                    <label for="inputZipCode" class="col-sm-2 control-label">Code postal</label>
                    <div class="col-sm-4">
                        <input id="inputZipCode" name="inputZipCode" type="text" class="form-control" placeholder="Code postal" maxlength="5" value="<?= $zipCode ?>"/>
                    </div>
                </div>
                <div id="div_inputCity" class="form-group">
                    <label for="inputCity" class="col-sm-2 control-label">Ville</label>
                    <div class="col-sm-4">
                        <input id="inputCity" name="inputCity" type="text" class="form-control" placeholder="Ville" value="<?= $city ?>"/>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnInscription" type="submit" class="btn btn-default">S'inscrire</button>
                    <input name="submittedForm" type="hidden" value="subscribeForm"/>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="js/verifs_formulaires_inscription.js"></script>
<?php include 'includes/bottom.php'; ?>
