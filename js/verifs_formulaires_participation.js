/*
 * Fonctions de conditionnement d'affichage
 */

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
    document.getElementById('div_inputFamilyName').className = 'form-group';
}

// Fonction de création des éléments de retour de soumission de formulaire
function createFeedbackElements(parentNode, icons, feedbackText) {
    // faut-il les icônes de retour ?
    if (icons) {
        // Icône OK
        var OKIcon = document.createElement("span");
        OKIcon.className = "glyphicon glyphicon-ok form-control-feedback";
        OKIcon.style.display = 'none';
        // Icône KO
        var KOIcon = document.createElement("span");
        KOIcon.className = "glyphicon glyphicon-remove form-control-feedback";
        KOIcon.style.display = 'none';
        // Ajout des deux icônes à l'élément parent
        parentNode.appendChild(OKIcon);
        parentNode.appendChild(KOIcon);
    }
    // Tooltip
    var tooltip = document.createElement("span");
    // Ajout du texte
    tooltip.appendChild(document.createTextNode(feedbackText));
    tooltip.className = "tooltip2";
    tooltip.style.display = 'none';
    // Ajout au noeud parent
    parentNode.appendChild(tooltip);
}

/*
 * Fonctions utiles
 */
// La fonction ci-dessous permet de récupérer la « tooltip » qui correspond à notre input
function getTooltip(element)
{
    while (element = element.nextSibling) {
        if (element.className && element.className.toString().indexOf('tooltip2') !== -1) {
            return element;
        }
    }

    return false;

}

// La fonction ci-dessous permet de récupérer l'icône de feedback qui correspond à notre input
function getFeedbackIcon(element, feedbackType)
{
    while (element = element.nextSibling) {
        if (element.className && element.className.toString().indexOf(feedbackType) !== -1) {
            return element;
        }
    }

    return false;

}

// La fonction change les styles afin de faire apparaïtre/disparaître les éléments en fonction de la conformité des valeurs du formulaire
function changeStyles(div, tooltip, OKIcon, KOIcon, conformity) {
    // si les élements doivent être visibles
    if (conformity)
    {
        div.className = 'form-group has-success has-feedback';
        tooltip.style.display = 'none';
        OKIcon.style.display = 'block';
        KOIcon.style.display = 'none';
    }
    // sinon, éléments invisibles
    else
    {
        div.className = 'form-group has-error has-feedback';
        tooltip.style.display = 'inline-block';
        OKIcon.style.display = 'none';
        KOIcon.style.display = 'block';
    }

}

/*
 * Ensemble des vérifications de formulaire
 */
var checkInscription = {};

checkInscription['inputFirstName'] = function(id) {

    // On récupère l'élément à vérifier, ainsi que le style du tooltip, ainsi que la div contenant cet élément
    var name = document.getElementById(id),
            tooltipStyle = getTooltip(name).style,
            div = document.getElementById("div_" + id),
            feedbackIconOKStyle = getFeedbackIcon(name, "glyphicon-ok").style,
            feedbackIconRemoveStyle = getFeedbackIcon(name, "glyphicon-remove").style;


    if (name.value.length >= 2) {
        div.className = 'form-group has-success has-feedback';
        tooltipStyle.display = 'none';
        feedbackIconOKStyle.display = 'block';
        feedbackIconRemoveStyle.display = 'none';
        return true;
    } else {
        div.className = 'form-group has-error has-feedback';
        tooltipStyle.display = 'inline-block';
        feedbackIconRemoveStyle.display = 'block';
        feedbackIconOKStyle.display = 'none';
        return false;
    }

};

// La fonction pour le prénom est la même que celle du nom
checkInscription['inputLastName'] = checkInscription['inputFirstName'];

checkInscription['inputEmail'] = function() {

    var mail = document.getElementById('inputEmail'),
            tooltipStyle = getTooltip(mail).style,
            div = document.getElementById("div_" + 'inputEmail'),
            feedbackIconOKStyle = getFeedbackIcon(mail, "glyphicon-ok").style,
            feedbackIconRemoveStyle = getFeedbackIcon(mail, "glyphicon-remove").style;

    var regex = /^[a-zA-Z0-9._-]+@[a-z._-]{2,}\.[a-z]{2,4}$/;

    if (regex.test(mail.value)) {
        div.className = 'form-group has-success has-feedback';
        tooltipStyle.display = 'none';
        feedbackIconOKStyle.display = 'block';
        feedbackIconRemoveStyle.display = 'none';
        return true;
    } else {
        div.className = 'form-group has-error has-feedback';
        tooltipStyle.display = 'inline-block';
        feedbackIconRemoveStyle.display = 'block';
        feedbackIconOKStyle.display = 'none';
        return false;
    }

};

checkInscription['inputSection'] = function() {

    var section = document.getElementById('inputSection'),
            tooltipStyle = getTooltip(section).style,
            div = document.getElementById("div_" + 'inputSection');

    if (section.options[section.selectedIndex].value !== 'none') {
        div.className = 'form-group has-success has-feedback';
        tooltipStyle.display = 'none';
        return true;
    } else {
        div.className = 'form-group has-error has-feedback';
        tooltipStyle.display = 'inline-block';
        return false;
    }

};

checkInscription['inputPromotion'] = function() {

    var promotion = document.getElementById('inputPromotion'),
            tooltip = getTooltip(promotion),
            div = document.getElementById("div_" + 'inputPromotion'),
            feedbackIconOK = getFeedbackIcon(promotion, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(promotion, "glyphicon-remove"),
            anneePromotion = parseInt(promotion.value);

    if (!isNaN(anneePromotion) && anneePromotion >= 1950 && anneePromotion <= 2015) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};

/*
 * Fonction principale
 */
// Utilisation d'une fonction anonyme pour éviter les variables globales.
(function() {

    var formInscription = document.getElementById('formInscription');

    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    formInscription.onsubmit = function() {

        // On insère les éléments HTML dans le document
        // Feedback prénom
        createFeedbackElements(document.getElementById('div_inputFirstNameFeedback'), true, 'Un prénom ne peut pas faire moins de 2 caractères');
        // nom
        createFeedbackElements(document.getElementById('div_inputLastNameFeedback'), true, 'Un nom ne peut pas faire moins de 2 caractères');
        // email
        createFeedbackElements(document.getElementById('div_inputEmailFeedback'), true, 'Le mail n\'est pas au bon format');
        // section
        createFeedbackElements(document.getElementById('div_inputSectionFeedback'), false, 'Veuillez sélectionner une section');
        // promo
        createFeedbackElements(document.getElementById('div_inputPromotionFeedback'), true, 'L\'année de promotion doit se situer entre 1950 et 2015');


        var result = true;

        for (var i in checkInscription) {
            result = checkInscription[i](i) && result;
        }

        if (result) {
            return result;
        }

        return false;

    };



})();