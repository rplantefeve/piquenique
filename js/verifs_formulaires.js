// Fonction de désactivation de l'affichage des indications de retour de formulaire
function deactivateTooltips()
{
    var spans = document.getElementsByTagName('span'),
            spansLength = spans.length;

    for (var i = 0; i < spansLength; i++) {
        if (spans[i].className.toString().indexOf('tooltip2') !== -1 || spans[i].className.toString().indexOf("form-control-feedback") !== -1) {
            spans[i].style.display = 'none';
        }
    }

}


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

// Utilisation d'une fonction anonyme pour éviter les variables globales.
(function() {

    var formInscription = document.getElementById('formInscription');

    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    formInscription.onsubmit = function() {

        var result = true;

        for (var i in checkInscription) {
            result = checkInscription[i](i) && result;
        }

        if (result) {
            return result;
        }

        return false;

    };

    // Maintenant que tout est initialisé, on peut désactiver les « tooltips »
    deactivateTooltips();

})();