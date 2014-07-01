<?php
require_once 'includes/participation.php';

// Initialisation des variables
$nom = null;
$prenom = null;
$email = null;
$nomJeuneFille = null;
$section = null;
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
$messageDesinscriptionEffectuee = false;

/*
 *  Traitement de l'envoi du formulaire
 */
// Si le formulaire a été envoyé 
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = $_POST['inputLastName'];
    $prenom = $_POST['inputFirstName'];
    $email = $_POST['inputEmail'];
    $nomJeuneFille = $_POST['inputFamilyName'];
    $section = $_POST['inputSection'];

    // On vérifie s'il existe en BDD
    if (verifyUser($email)) {
        // Si la case pour s'inscrire est cochée
        if (isset($_POST['chkBoxInscription']) && $_POST['chkBoxInscription'] == "on") {
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
        // La case n'est pas cochée
        else {
            // Désincription
            changerInscriptionParticipant($email, "non");
            // Message, désinscription effectuée
            $messageDesinscriptionEffectuee = true;
        }
    }
    // S'il n'existe pas en BDD
    else {
        // Si la case pour s'inscrire est cochée
        if (isset($_POST['chkBoxInscription']) && $_POST['chkBoxInscription'] == "on") {
            // enregistrer et inscrire le participant
            enregisterInscrireParticipant($nom, $prenom, $nomJeuneFille, $email, $section, 'oui');
            // Message, inscription prise en compte
            $messageInscriptionEffectuee = true;
        }
        // la case n'est pas cochée
        else {
            // enregistrer et désinscrire le participant
            enregisterInscrireParticipant($nom, $prenom, $nomJeuneFille, $email, $section, 'non');
            // Message, désinscription prise en compte
            $messageDesinscriptionEffectuee = true;
        }
    }
}

$title = "Pique-Nique : Inscription / Désinscription";
include_once 'includes/top.php';



if (isset($_GET['num'])) {
    $choix = $_GET['num'];
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Inscription au pique-nique</h3>
    </div>
    <div class="panel-body">
        <p>Veuillez remplir le formulaire ci-dessous afin de vous inscrire (ou vous désinscrire) au pique-nique du 13 Septembre 2014.</p>
        <form id="formInscription" name="formInscription" class="form-horizontal" role="form" method="POST" action="formulaire_modif_participation.php">
            <div id="div_inputFirstName" class="form-group">
                <label for="inputFirstName" class="col-sm-2 control-label">Prénom</label>
                <div class="col-sm-4">
                    <input id="inputFirstName" name="inputFirstName" type="text" class="form-control"  placeholder="Prénom" value="<?= $prenom ?>"/>
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="tooltip2">Un prénom ne peut pas faire moins de 2 caractères</span>
                </div>
            </div>
            <div id="div_inputLastName" class="form-group">
                <label for="inputLastName" class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-4">
                    <input id="inputLastName" name="inputLastName" type="text" class="form-control" placeholder="Nom" value="<?= $nom ?>"/>
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="tooltip2">Un nom ne peut pas faire moins de 2 caractères</span>
                </div>
            </div>
            <div id="div_buttonFamilyName" class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-4">
                    <button type="button" class="btn btn-info btn-group-sm" onclick="afficherNomJeuneFille();">Mariée ? Cliquez ici</button>
                </div>
            </div>
            <div id="div_inputFamilyName" class="form-group">
                <label for="inputFamilyName" class="col-sm-2 control-label">Nom de jeune fille</label>
                <div class="col-sm-4">
                    <input id="inputFamilyName" name="inputFamilyName" type="text" class="form-control" placeholder="Nom de jeune fille" value="<?= $nomJeuneFille ?>"/>
                </div>
            </div>
            <div id="div_inputEmail" class="form-group">
                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input id="inputEmail" name="inputEmail" type="email" class="form-control" placeholder="pseudonyme@domaine.fr" value="<?= $email ?>"/>
                    <span class="glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class="tooltip2">Le mail n'est pas au bon format</span>
                </div>
            </div>
            <div id="div_inputEmail" class="form-group">
                <label for="inputSection" class="col-sm-2 control-label">Section</label>
                <div class="col-sm-4">
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
                    <span class = "glyphicon glyphicon-ok form-control-feedback"></span>
                    <span class = "glyphicon glyphicon-remove form-control-feedback"></span>
                    <span class = "tooltip2">Veuillez sélectionner une section</span>
                </div>
            </div>
            <div class = "form-group">
                <div class = "col-sm-offset-2 col-sm-10">
                    <div class = "checkbox">
                        <label>
                            <input id = "chkBoxInscription" name = "chkBoxInscription" type = "checkbox" <?php
                            if ($_SERVER['REQUEST_METHOD'] == "GET" || isset($_POST['chkBoxInscription'])) {
                                echo 'checked="checked"';
                            }
                            ?> onchange="changerBoutonInscription(this);"> Je participe au pique-nique
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="btnInscription" type="submit" class="btn btn-default"><?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['chkBoxInscription'])) {
                            echo 'Se désinscrire';
                        } else {
                            echo 'S\'inscrire';
                        }
                        ?></button>
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
        } else if ($messageDesinscriptionEffectuee) {
            ?>
            <div class="alert alert-info" role="alert">
                <strong>Dommage !</strong> Vous vous êtes désinscrit au pique-nique.
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
    // Fonction de changement du nom du bouton
    function changerBoutonInscription(chkbox)
    {
        var button = document.getElementById("btnInscription");

        if (chkbox.checked === true)
        {
            button.innerHTML = "S'inscrire";
        }
        else
        {
            button.innerHTML = "Se désinscrire";
        }
    }

    // Afficher le champ 'Nom de jeune fille'
    function afficherNomJeuneFille()
    {
        document.getElementById('div_buttonFamilyName').style.display = 'none';
        document.getElementById('div_inputFamilyName').style.display = 'block';
    }
</script>
<script src="js/verifs_formulaires.js"></script>
<?php include 'includes/bottom.php'; ?>
