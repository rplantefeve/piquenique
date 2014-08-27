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

checkInscription['inputFirstName'] = function(id) {

    // On récupère l'élément à vérifier, ainsi que le style du tooltip, ainsi que la div contenant cet élément
    var name = document.getElementById(id),
            tooltip = getTooltip(name),
            div = document.getElementById("div_" + id),
            feedbackIconOK = getFeedbackIcon(name, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(name, "glyphicon-remove");


    if (name.value.length >= 2) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};

// La fonction pour le prénom est la même que celle du nom
checkInscription['inputLastName'] = checkInscription['inputFirstName'];

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

checkInscription['inputSection'] = function() {

    var section = document.getElementById('inputSection'),
            tooltip = getTooltip(section),
            div = document.getElementById("div_" + 'inputSection');

    if (section.options[section.selectedIndex].value !== 'none') {
        changeStyles(div, tooltip, null, null, true);
        return true;
    } else {
        changeStyles(div, tooltip, null, null, false);
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

    // Si la valeur est "non applicable" OU SINON si l'année est bien un entier compris entre 1950 et 2015
    if (promotion.value.toUpperCase() === "N/A" || (!isNaN(anneePromotion) && anneePromotion >= 1950 && anneePromotion <= 2015)) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};