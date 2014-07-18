/*
 * Suite des vérifications de formulaire
 */

checkInscription['inputCivility'] = function() {

    var civility = document.getElementById('inputCivility'),
            tooltip = getTooltip(civility),
            div = document.getElementById("div_" + 'inputCivility');
    if (civility.options[civility.selectedIndex].value !== 'none') {
        changeStyles(div, tooltip, null, null, true);
        return true;
    } else {
        changeStyles(div, tooltip, null, null, false);
        return false;
    }

};
checkInscription['inputEmailConfirm'] = function() {

    var mail = document.getElementById('inputEmailConfirm'),
            tooltip = getTooltip(mail),
            div = document.getElementById("div_" + 'inputEmailConfirm'),
            feedbackIconOK = getFeedbackIcon(mail, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(mail, "glyphicon-remove");
    var regex = /^[a-zA-Z0-9._-]+@[a-z._-]{2,}\.[a-z]{2,4}$/;
    var emailOrig = document.getElementById('inputEmail');
    if (regex.test(emailOrig.value) && emailOrig.value === mail.value) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};
checkInscription['inputPassword'] = function() {

// On récupère l'élément à vérifier, ainsi que le style du tooltip, ainsi que la div contenant cet élément
    var password = document.getElementById('inputPassword'),
            tooltip = getTooltip(password),
            div = document.getElementById("div_inputPassword"),
            feedbackIconOK = getFeedbackIcon(name, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(name, "glyphicon-remove");
    if (password.value.length >= 6) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};
checkInscription['inputPasswordConfirm'] = function() {

// On récupère l'élément à vérifier, ainsi que le style du tooltip, ainsi que la div contenant cet élément
    var password = document.getElementById('inputPasswordConfirm'),
            tooltip = getTooltip(password),
            div = document.getElementById("div_inputPasswordConfirm"),
            feedbackIconOK = getFeedbackIcon(name, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(name, "glyphicon-remove");
    var passwordOrig = document.getElementById('inputPassword');
    if (passwordOrig.value.length >= 6 && passwordOrig.value === password.value) {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
        return true;
    } else {
        changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
        return false;
    }

};
checkInscription['inputZipCode'] = function() {

    var zipCode = document.getElementById('inputZipCode'),
            tooltip = getTooltip(zipCode),
            div = document.getElementById("div_" + 'inputZipCode'),
            feedbackIconOK = getFeedbackIcon(zipCode, "glyphicon-ok"),
            feedbackIconRemove = getFeedbackIcon(zipCode, "glyphicon-remove"),
            codePostal = parseInt(zipCode.value);
    // Si la valeur est non null ET ALORS si le code postal fait 5 chiffres ET que c'est bien un nombre
    if (zipCode.value) {
        if (zipCode.value.length === 5 && !isNaN(codePostal)) {
            changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, true);
            return true;
        } else {
            changeStyles(div, tooltip, feedbackIconOK, feedbackIconRemove, false);
            return false;
        }
    } else {
        return true;
    }

};

var checkInscriptionBis = {};
checkInscriptionBis['inputZipCode'] = checkInscription['inputZipCode'];

/*
 * Fonction principale
 */
// Utilisation d'une fonction anonyme pour éviter les variables globales.
(function() {

    var formInscription = document.getElementById('formInscription');
    // Sur l'évènement onsubmit du formulaire (soumission), on lance les vérifications sur la saisie de l'utilisateur
    if (formInscription)
    {
        document.getElementById('inputEmailConfirm').onpaste = function() {
            return false; // on empêche
        };
        document.getElementById('inputPasswordConfirm').onpaste = function() {
            return false; // on empêche
        };

        formInscription.onsubmit = function() {

            // On insère les éléments HTML dans le document
            // civilité
            createFeedbackElements(document.getElementById('div_inputCivilityFeedback'), false, 'Veuillez sélectionner une civilité ');
            // Feedback prénom
            createFeedbackElements(document.getElementById('div_inputFirstNameFeedback'), true, 'Un prénom ne peut pas faire moins de 2 caractères');
            // nom
            createFeedbackElements(document.getElementById('div_inputLastNameFeedback'), true, 'Un nom ne peut pas faire moins de 2 caractères');
            // email
            createFeedbackElements(document.getElementById('div_inputEmailFeedback'), true, 'Le mail n\'est pas au bon format');
            // confirmation email
            createFeedbackElements(document.getElementById('div_inputEmailConfirmFeedback'), true, 'Les adresses email doivent correspondre');
            // password
            createFeedbackElements(document.getElementById('div_inputPasswordFeedback'), true, 'Le mot de passe doit avoir une longueur minimum de 6 caractères');
            // confirmation password
            createFeedbackElements(document.getElementById('div_inputPasswordConfirmFeedback'), true, 'Les mots de passe doivent correspondre');
            // section
            createFeedbackElements(document.getElementById('div_inputSectionFeedback'), false, 'Veuillez sélectionner une section');
            // promo
            createFeedbackElements(document.getElementById('div_inputPromotionFeedback'), true, 'L\'année de promotion doit se situer entre 1950 et 2015 (N/A si non applicable)');
            // codePostal
            createFeedbackElements(document.getElementById('div_inputZipCodeFeedback'), true, 'Le code postal doit être un nombre à cinq chiffres');
            var result = true;
            for (var i in checkInscription) {
                result = checkInscription[i](i) && result;
            }

            if (result) {
                return result;
            }

            return false;
        };
    } else {

        var formInscriptionBis = document.getElementById('formInscriptionBis');

        if (formInscriptionBis) {
            formInscriptionBis.onsubmit = function() {

                // On insère les éléments HTML dans le document
                // codePostal
                createFeedbackElements(document.getElementById('div_inputZipCodeFeedback'), true, 'Le code postal doit être un nombre à cinq chiffres');

                var result = true;
                for (var i in checkInscriptionBis) {
                    result = checkInscriptionBis[i](i) && result;
                }

                if (result) {
                    return result;
                }

                return false;
            };
        }
    }
})();