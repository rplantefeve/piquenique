/*
 * Fonction principale
 */
// Utilisation d'une fonction anonyme pour éviter les variables globales.
(function() {

    var formParticipation = document.getElementById('formParticipation');

    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    formParticipation.onsubmit = function() {

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

})();