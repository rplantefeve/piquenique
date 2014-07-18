/*
 * Ensemble des vérifications de formulaire
 */
var checkParticipation = {};

checkParticipation['inputEmail'] = function() {

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

    var formParticipation = document.getElementById('formParticipation');

    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    formParticipation.onsubmit = function() {

        // On insère les éléments HTML dans le document
        // email
        createFeedbackElements(document.getElementById('div_inputEmailFeedback'), true, 'Le mail n\'est pas au bon format');

        var result = true;

        for (var i in checkParticipation) {
            result = checkParticipation[i](i) && result;
        }

        if (result) {
            return result;
        }

        return false;

    };



})();