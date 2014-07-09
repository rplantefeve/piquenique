/*
 * Fonctions de conditionnement d'affichage
 */


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
        if (OKIcon)
            OKIcon.style.display = 'block';
        if (KOIcon)
            KOIcon.style.display = 'none';
    }
    // sinon, éléments invisibles
    else
    {
        div.className = 'form-group has-error has-feedback';
        tooltip.style.display = 'inline-block';
        if (OKIcon)
            OKIcon.style.display = 'none';
        if (KOIcon)
            KOIcon.style.display = 'block';
    }

}

/*
 * Ensemble des vérifications de formulaire
 */
var checkInscription = {};

checkInscription['inputEmail'] = function() {

    var mail = document.getElementById('inputEmail'),
            tooltip = getTooltip(mail),
            div = document.getElementById("div_" + 'inputEmail'),
            feedbackIconOK = getFeedbackIcon(mail, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(mail, "glyphicon-remove");

    var regex = /^[a-zA-Z0-9._-]+@[a-z._-]{2,}\.[a-z]{2,4}$/;

    if (regex.test(mail.value)) {
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
        // email
        createFeedbackElements(document.getElementById('div_inputEmailFeedback'), true, 'Le mail n\'est pas au bon format');

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