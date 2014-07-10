<?php
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

$title = "Registre : Inscription";
include_once 'includes/top.php';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inscription au registre</h3>
    </div>
    <div class="panel-body">
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
                            <option value="none"> </option>
                            <option value="M.">M.</option>
                            <option value="Mme">Mme</option>
                            <option value="Mlle">Mlle</option>
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
                        <input id="inputEmailConfirm" name="inputEmailConfirm" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $emailConfirm ?>"/>
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
                        <input id="inputPromotion" name="inputPromotion" type="text" class="form-control" placeholder="Année de promotion" value="<?= $promotion ?>"/>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-muted">Entreprise</legend>
            </fieldset>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnInscription" type="submit" class="btn btn-default">S'inscrire</button>
                </div>
            </div>
        </form>
        <!--
                    <fieldset><legend>Entreprise</legend>
                        <label for="fonction">Fonction dans l'entreprise : </label>
                        <input type="text" name="fonction"/><br/>
            
                        <label for="nomEise">Nom de l'entreprise : </label>
                        <input type="text" name="nomEise"/><br/>
            
                        <label for="adresseEise1">Adresse de l'entreprise : </label>
                        <input type="text" name="adresseEise1"/><br/>
            
                        <label for="adresseEise2">Complement adresse : </label>
                        <input type="text" name="adresseEise2"/><br/>
            
                        <label for="codePostalEise">Code Postal : </label>
                        <input type="text" name="codePostalEise"/><br/>
            
                        <label for="villeEise">Ville : </label>
                        <input text="text" name="villeEise"/><br/>
                    </fieldset>
            
        -->
    </div>
</div>
<script src="js/verifs_formulaires_inscription.js"></script>
<?php include 'includes/bottom.php'; ?>
