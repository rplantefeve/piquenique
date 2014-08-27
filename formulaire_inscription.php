<?php
require_once 'includes/inscription.php';
require_once 'includes/participation.php';
require_once 'includes/utilisateur.php';

// Initialisation des variables
$formSubmitted = false;
$miseAJourDepuisParticipation = false;
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
$messageInscriptionMAJ = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// si le formulaire a été envoyé en POST depuis la page de participation
if ($_SERVER['REQUEST_METHOD'] === "POST" && filter_input(INPUT_POST, 'submittedForm') === "subscriptionAfterParticipation") {
    $formSubmitted = true;

    $options = array(
        'inputNom' => FILTER_SANITIZE_STRING,
        'inputNomJeuneFille' => FILTER_SANITIZE_STRING,
        'inputPrenom' => FILTER_SANITIZE_STRING,
        'inputEmail' => FILTER_SANITIZE_EMAIL,
        'inputSection' => FILTER_SANITIZE_STRING,
        'inputPromotion' => FILTER_SANITIZE_STRING
    );

    // On filtre les valeurs rentrées par l'utilisateur
    $resultat = filter_input_array(INPUT_POST, $options);

    // On récupère les valeurs filtrées
    $nom = $resultat['inputNom'];
    $nomJeuneFille = $resultat['inputNomJeuneFille'];
    $prenom = $resultat['inputPrenom'];
    $email = $resultat['inputEmail'];
    $emailConfirm = $email;
    $section = $resultat['inputSection'];
    $promotion = $resultat['inputPromotion'];

    $miseAJourDepuisParticipation = true;
}
// Si le formulaire a été envoyé
else if ($_SERVER['REQUEST_METHOD'] === "POST" && filter_input(INPUT_POST, 'submittedForm') === "subscribeForm") {
    $formSubmitted = true;

    $options = array(
        'inputCivility' => FILTER_SANITIZE_STRING,
        'inputLastName' => FILTER_SANITIZE_STRING,
        'inputFirstName' => FILTER_SANITIZE_STRING,
        'inputEmail' => FILTER_SANITIZE_EMAIL,
        'inputFamilyName' => FILTER_SANITIZE_STRING,
        'inputSection' => FILTER_SANITIZE_STRING,
        'inputPromotion' => FILTER_SANITIZE_STRING,
        'inputFirmName' => FILTER_SANITIZE_STRING,
        'inputFunction' => FILTER_SANITIZE_STRING,
        'inputAddress1' => FILTER_SANITIZE_STRING,
        'inputAddress2' => FILTER_SANITIZE_STRING,
        'inputZipCode' => FILTER_SANITIZE_STRING,
        'inputCity' => FILTER_SANITIZE_STRING,
        'subscriptionAfterParticipation' => FILTER_SANITIZE_STRING
    );

    // On filtre les valeurs rentrées par l'utilisateur
    $resultat = filter_input_array(INPUT_POST, $options);

    // On récupère les valeurs filtrées
    $civility = $resultat['inputCivility'];
    $nom = $resultat['inputLastName'];
    $prenom = $resultat['inputFirstName'];
    $email = $resultat['inputEmail'];
    $nomJeuneFille = $resultat['inputFamilyName'];
    // Pas de filtre pour le password (car hashage md5)
    $password = $_POST['inputPassword'];
    $section = $resultat['inputSection'];
    $promotion = $resultat['inputPromotion'];
    $firmName = $resultat['inputFirmName'];
    $function = $resultat['inputFunction'];
    $address1 = $resultat['inputAddress1'];
    $address2 = $resultat['inputAddress2'];
    $zipCode = $resultat['inputZipCode'];
    $city = $resultat['inputCity'];
    $subscriptionAfterParticipation = $resultat['subscriptionAfterParticipation'];

    // Si la demande d'inscription provient de quelqu'un qui vient d'enregistrer sa participation
    if ($subscriptionAfterParticipation) {
        // il faut mettre à jour les données de ce participant
        mettreAJourParticipant($email, $civility, $password, $firmName, $function, $address1, $address2, $zipCode, $city);
        $messageInscriptionEffectuee = true;
        // authentification automatique de l'utilisateur
        // on démarre la session
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['user'] = $email;
    }
    // sinon si on vérifie l'existence de l'utilisateur
    else if (verifierExistenceParticipant($email)) {
        $messageDejaInscrit = true;
    }
    // sinon, on créé l'utilisateur
    else {
        // création et inscription au registre
        inscrireParticipant($civility, $nom, $prenom, $email, $nomJeuneFille, $password, $section, $promotion, $firmName, $function, $address1, $address2, $zipCode, $city);
        $messageInscriptionEffectuee = true;
        // authentification automatique de l'utilisateur
        // on démarre la session
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['user'] = $email;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === "POST" && filter_input(INPUT_POST, 'submittedForm') === "subscribeFormAuthenticated") {
    // il faut mettre à jour les informations concernant l'entreprise
    $formSubmitted = true;

    $options = array(
        'userEmail' => FILTER_SANITIZE_EMAIL,
        'inputFirmName' => FILTER_SANITIZE_STRING,
        'inputFunction' => FILTER_SANITIZE_STRING,
        'inputAddress1' => FILTER_SANITIZE_STRING,
        'inputAddress2' => FILTER_SANITIZE_STRING,
        'inputZipCode' => FILTER_SANITIZE_STRING,
        'inputCity' => FILTER_SANITIZE_STRING
    );

    // On filtre les valeurs rentrées par l'utilisateur
    $resultat = filter_input_array(INPUT_POST, $options);

    // On récupère les valeurs filtrées
    $email = $resultat['userEmail'];
    $firmName = $resultat['inputFirmName'];
    $function = $resultat['inputFunction'];
    $address1 = $resultat['inputAddress1'];
    $address2 = $resultat['inputAddress2'];
    $zipCode = $resultat['inputZipCode'];
    $city = $resultat['inputCity'];

    // maj inscrit
    mettreAJourInscrit($email, $firmName, $function, $address1, $address2, $zipCode, $city);
    $messageInscriptionMAJ = true;
}

$title = "Registre : Inscription";
include_once 'includes/top.php';

// si l'utilisateur est loggué
if ($isAUserIsLogged) {
    $utilisateur = getCompleteInformationsByEmailAddress($_SESSION['user']);
}
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
        } elseif ($messageDejaInscrit) {
            ?>
            <div class="alert alert-danger" role="alert">
                <strong>Attention !</strong> Cet utilisateur est déjà enregistré.
            </div>
            <?php
        } elseif ($messageInscriptionMAJ) {
            ?>
            <div class="alert alert-success" role="alert">
                <strong>Merci !</strong> Les nouvelles informations ont été enregistrées.
            </div>
            <?php
        }
        // Si personne de connecté
        if (!$isAUserIsLogged) {
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
                            <input id="inputFirstName" name="inputFirstName" type="text" class="form-control"  <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>placeholder="Prénom" value="<?= $prenom ?>"/>
                        </div>
                    </div>
                    <div id="div_inputLastName" class="form-group">
                        <label for="inputLastName" class="col-sm-2 control-label">Nom *</label>
                        <div id="div_inputLastNameFeedback" class="col-sm-4">
                            <input id="inputLastName" name="inputLastName" type="text" class="form-control" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>placeholder="Nom" value="<?= $nom ?>"/>
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
                            <input id="inputFamilyName" name="inputFamilyName" type="text" class="form-control" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>placeholder="Nom de jeune fille" value="<?= $nomJeuneFille ?>"/>
                        </div>
                    </div>
                    <div id="div_inputEmail" class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email *</label>
                        <div id="div_inputEmailFeedback" class="col-sm-4">
                            <input id="inputEmail" name="inputEmail" type="email" class="form-control" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                        </div>
                    </div>
                    <div id="div_inputEmailConfirm" class="form-group">
                        <label for="inputEmailConfirm" class="col-sm-2 control-label">Confirmer l'email *</label>
                        <div id="div_inputEmailConfirmFeedback" class="col-sm-4">
                            <input id="inputEmailConfirm" name="inputEmailConfirm" type="email" class="form-control" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>autocomplete="off" placeholder="pseudonyme@domaine.fr" value="<?= $emailConfirm ?>"/>
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
                            <select id="inputSection" name="inputSection" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>class="form-control">
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
                            <input id="inputPromotion" name="inputPromotion" type="text" class="form-control" <?php
                            if ($miseAJourDepuisParticipation) {
                                echo 'readonly ';
                            }
                            ?>placeholder="Année de promotion : N/A si non applicable" value="<?= $promotion ?>"/>
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
                        <div id="div_inputZipCodeFeedback" class="col-sm-4">
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
                        <input name="subscriptionAfterParticipation" type="hidden" value="<?= $miseAJourDepuisParticipation; ?>"/>
                    </div>
                </div>
            </form>
            <?php
        } // fin si personne de connecté
        else {
            // si un utilisateur est connecté
            echo '<p>Bonjour ' . $utilisateur['civilite'] . ' ' . $utilisateur['prenom'] . ' ' . $utilisateur['nom'] . ' , vous faites déjà partie du registre des anciens.</p>';
            echo '<p>Souhaitez-vous nous donner plus d\'informations vous concernant ? Si oui, veuillez remplir le formulaire ci-dessous :</p>';
            ?>
            <form id="formInscriptionBis" action="formulaire_inscription.php" method="POST" class="form-horizontal">
                <fieldset>
                    <legend class="text-muted">Entreprise</legend>
                    <div id="div_inputFunction" class="form-group">
                        <label for="inputFunction" class="col-sm-2 control-label">Fonction dans l'entreprise</label>
                        <div class="col-sm-4">
                            <input id="inputFunction" name="inputFunction" type="text" class="form-control" placeholder="Fonction dans l'entreprise" value="<?= $utilisateur['fonction'] ?>"/>
                        </div>
                    </div>
                    <div id="div_inputFirmName" class="form-group">
                        <label for="inputFirmName" class="col-sm-2 control-label">Nom de l'entreprise</label>
                        <div class="col-sm-4">
                            <input id="inputFirmName" name="inputFirmName" type="text" class="form-control" placeholder="Nom de l'entreprise" value="<?= $utilisateur['nomEise'] ?>"/>
                        </div>
                    </div>
                    <div id="div_inputAddress1" class="form-group">
                        <label for="inputAddress1" class="col-sm-2 control-label">Adresse</label>
                        <div class="col-sm-4">
                            <input id="inputAddress1" name="inputAddress1" type="text" class="form-control" placeholder="Adresse" value="<?= $utilisateur['adresseEise1'] ?>"/>
                        </div>
                    </div>
                    <div id="div_inputAddress2" class="form-group">
                        <label for="inputAddress2" class="col-sm-2 control-label">Complément d'adresse</label>
                        <div class="col-sm-4">
                            <input id="inputAddress2" name="inputAddress2" type="text" class="form-control" placeholder="Complément d'adresse" value="<?= $utilisateur['adresseEise2'] ?>"/>
                        </div>
                    </div>
                    <div id="div_inputZipCode" class="form-group">
                        <label for="inputZipCode" class="col-sm-2 control-label">Code postal</label>
                        <div id="div_inputZipCodeFeedback" class="col-sm-4">
                            <input id="inputZipCode" name="inputZipCode" type="text" class="form-control" placeholder="Code postal" maxlength="5" value="<?= $utilisateur['codePostal'] ?>"/>
                        </div>
                    </div>
                    <div id="div_inputCity" class="form-group">
                        <label for="inputCity" class="col-sm-2 control-label">Ville</label>
                        <div class="col-sm-4">
                            <input id="inputCity" name="inputCity" type="text" class="form-control" placeholder="Ville" value="<?= $utilisateur['ville'] ?>"/>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="btnInscription" type="submit" class="btn btn-default">Enregistrer</button>
                        <input name="userEmail" type="hidden" value="<?= $utilisateur['mail'] ?>"/>
                        <input name="submittedForm" type="hidden" value="subscribeFormAuthenticated"/>
                    </div>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
</div>

<script src="js/verifs_formulaires_common.js"></script>
<script src="js/verifs_formulaires_inscription.js"></script>
<?php include 'includes/bottom.php'; ?>
