// Vérification du nombre de participants
checkInscription['inputParticipantsNumber'] = function() {

    var participants = document.getElementById('inputParticipantsNumber'),
            tooltip = getTooltip(participants),
            div = document.getElementById("div_" + 'inputParticipantsNumber'),
            feedbackIconOK = getFeedbackIcon(participants, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(participants, "glyphicon-remove"),
            nbParticipants = parseInt(participants.value);

    // Si la valeur est un entier ET si elle est positive
    if (!isNaN(nbParticipants) && nbParticipants === parseFloat(participants.value) && nbParticipants > 0) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};

// Vérifications dans le cas d'un utilisateur déjà inscrit (beaucoup moins d'infos)
var checkInscription2 = {};

checkInscription2['inputParticipantsNumber'] = checkInscription['inputParticipantsNumber'];

/*
 * Fonction principale
 */
// Utilisation d'une fonction anonyme pour éviter les variables globales.
(function() {

    var formParticipation = document.getElementById('formParticipation');

    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    if (formParticipation) {
        formParticipation.onsubmit = function() {

            // On insère les éléments HTML dans le document
            // Feedback prénom
            createFeedbackElements(document.getElementById('div_inputFirstNameFeedback'), true, 'Un prénom ne peut pas faire moins de 2 caractères');
            // nom
            createFeedbackElements(document.getElementById('div_inputLastNameFeedback'), true, 'Un nom ne peut pas faire moins de 2 caractères');
            // nombre de participants
            createFeedbackElements(document.getElementById('div_inputParticipantsNumberFeedback'), true, 'Veuillez svp renseigner le nombre de participants (si seul(e), inscrire la valeur 1)');
            // email
            createFeedbackElements(document.getElementById('div_inputEmailFeedback'), true, 'Le mail n\'est pas au bon format');
            // section
            createFeedbackElements(document.getElementById('div_inputSectionFeedback'), false, 'Veuillez sélectionner une section');
            // promo
            createFeedbackElements(document.getElementById('div_inputPromotionFeedback'), true, 'L\'année de promotion doit se situer entre 1950 et 2015 (N/A si non applicable)');


            var result = true;

            for (var i in checkInscription) {
                result = checkInscription[i](i) && result;
            }

            if (result) {
                return result;
            }

            return false;

        };
    }
    // si l'utilisateur est loggué, ce n'est pas le même formulaire
    else {
        var formParticipation2 = document.getElementById('formParticipation2');

        if (formParticipation2) {
            formParticipation2.onsubmit = function() {

                // On insère les éléments HTML dans le document
                // nombre de participants
                createFeedbackElements(document.getElementById('div_inputParticipantsNumberFeedback'), true, 'Veuillez svp renseigner le nombre de participants (si seul(e), inscrire la valeur 1)');

                var result = true;

                for (var i in checkInscription2) {
                    result = checkInscription2[i](i) && result;
                }

                if (result) {
                    return result;
                }

                return false;

            };
        }
    }

})();