<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Pique-Nique</title>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/font.css"/>
    </head>
    <body>

        <div class="container">   
            <header>

                <div id="titre">
                    <h1>Lycée St-Michel</h1>
                    <h3>Retrouvons nous le temps d'un repas...</h3>
                </div>


                <nav>
                    <p>
                    <ul>
                        <li><a href="index.php" id="lienMenu">Accueil</a></li>
                        <li><a href="news.php" id="lienMenu">News</a></li>
                        <li><a href="formulaire_inscription.php" id="lienMenu">Enregistrement</a></li>
                        <li><a href="formulaire_modif_deins.php?num=1" id="lienMenu">Participation</a></li>
                        <li><a href="formulaire_modif_deins.php?num=2" id="lienMenu">Désinscription</a></li>
                        <li><a href="mention_legales.php" id="lienMenu">Mentions légales</a></li>
                    </ul>
                    </p>
                </nav>             
            </header>
        </div> 

        <section id="corpsPage">

            <p id="champObligatoire">
                * champs obligatoires
            </p>
            <form id="myForm" action="traitement_inscription.php" method="post">


                <fieldset><legend>Coordonnées</legend>
                    <label for="sexe">Vous êtes : </label>
                    <select name="sexe" id="sexe">
                        <option value="none"></option>
                        <option value="H">Homme</option>
                        <option value="F">Femme</option>
                    </select>
                    <span class="tooltip">Vous devez sélectionnez votre sexe</span>
                    <br/>

                    <label for="nom">Nom : </label>
                    <input type="text" name="nom" id="nom"/>*
                    <span class="tooltip">Un nom ne peut pas faire moins de 2 caractères</span>
                    <br/>

                    <label for="nomAuBts">Nom au moment du BTS : </label>
                    <input type="text" name="nomAuBts" id="nomAuBts"/>*
                    <span class="tooltip">Un nom ne peut pas faire moins de 2 caractères</span>
                    <br/>

                    <label for="prenom">Prénom : </label>
                    <input type="text" name="prenom" id="prenom"/>*
                    <span class="tooltip">Un prénom ne peut pas faire moins de 2 caractères</span>
                    <br/>

                    <label for="mail1">E-mail : </label>
                    <input type="text" name="mail1" id="mail1" onblur="verifMail(this)"/>*
                    <span class="tooltip">Le mail n'est pas au bon format</span>
                    <br/>


                    <label for="mail2">Confirmer l'e-mail : </label>
                    <input type="text" name="mail2" id="mail2"/>*
                    <span class="tooltip">Le mail de confirmation doit être identique à celui d'origine</span>
                    <br/>

                    <label for="numTel">Mot de passe : </label>
                    <input type="password" name="password1" id="password1"/>*
                    <span class="tooltip">Le mot de passe ne doit pas faire moins de 6 caractères</span>
                    <br/>

                    <label for="numTel">Confirmer le mot de passe : </label>
                    <input type="password" name="password2" id="password2"/>*
                    <span class="tooltip">Le mot de passe de confirmation doit être identique à celui d'origine</span>
                    <br/>

                </fieldset>

                <fieldset><legend>Information</legend>
                    <label for="section">Section : </label>
                    <select name="section" id="section">
                        <option value="none">Séléctionner votre section</option>
                        <option value="SIO">SIO</option>
                        <option value="IG">IG</option>
                        <option value="IRIS">IRIS</option>
                        <option value="Assistant de projet">Assistant de projet</option>
                        <option value="Professeur">Professeur</option>
                    </select>
                    <span class="tooltip">Vous devez sélectionner votre section de promotion</span>
                    <br/>

                    <label for="anneeSorti">Année de sortie du lycée : </label>
                    <input type="text" name="anneeSorti" id="anneeSorti"/>* (2015 si vous n'êtes pas concerné)
                    <span class="tooltip">L'année doit être inférieure à 2015</span>
                    <br/>
                </fieldset>

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

                <br/>
                <span class="form_col"></span>
                <div id="bouton">
                    <input type="submit" value="M'inscrire" id="btn"/> <input type="reset" value="Réinitialiser" id="btn"/>
                </div>


            </form>
        </section>

        <script>
            document.getElementById('mail2').onpaste = function() {
                alert('Merci de ne pas copier/coller');        // on prévient
                return false;        // on empêche
            };
        </script>
        <script>
            document.getElementById('password1').onpaste = function() {
                alert('Merci de ne pas copier/coller');        // on prévient
                return false;        // on empêche
            };
        </script>
        <script>
            document.getElementById('password2').onpaste = function() {
                alert('Merci de ne pas copier/coller');        // on prévient
                return false;        // on empêche
            };
        </script>
        <script>
            (function() { // On utilise une IEF pour ne pas polluer l'espace global

                // Fonction de désactivation de l'affichage des « tooltips »

                function deactivateTooltips() {

                    var spans = document.getElementsByTagName('span'),
                            spansLength = spans.length;

                    for (var i = 0; i < spansLength; i++) {
                        if (spans[i].className === 'tooltip') {
                            spans[i].style.display = 'none';
                        }
                    }

                }


                // La fonction ci-dessous permet de récupérer la « tooltip » qui correspond à notre input

                function getTooltip(element) {

                    while (element = element.nextSibling) {
                        if (element.className === 'tooltip') {
                            return element;
                        }
                    }

                    return false;

                }


                // Fonctions de vérification du formulaire, elles renvoient « true » si tout est OK

                var check = {}; // On met toutes nos fonctions dans un objet littéral

                check['sexe'] = function() {

                    var section = document.getElementById('sexe'),
                            tooltipStyle = getTooltip(sexe).style;

                    if (sexe.options[sexe.selectedIndex].value !== 'none') {
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['nom'] = function(id) {

                    var name = document.getElementById(id),
                            tooltipStyle = getTooltip(name).style;

                    if (name.value.length >= 2) {
                        name.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        name.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['nomAuBts'] = check['nom']; //La fonction pour le nom au bts est la même que celle du nom
                check['prenom'] = check['nom']; // La fonction pour le prénom est la même que celle du nom

                check['mail1'] = function() {

                    var mail1 = document.getElementById('mail1'),
                            tooltipStyle = getTooltip(mail1).style;
                    var regex = /^[a-zA-Z0-9._-]+@[a-z._-]{2,}\.[a-z]{2,4}$/;

                    if (regex.test(mail1.value)) {
                        mail1.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        mail1.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['mail2'] = function() {

                    var mail1 = document.getElementById('mail1'),
                            mail2 = document.getElementById('mail2'),
                            tooltipStyle = getTooltip(mail2).style;

                    if (mail1.value === mail2.value && mail2.value !== '') {
                        mail2.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        mail2.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['password1'] = function() {

                    var password1 = document.getElementById('password1'),
                            tooltipStyle = getTooltip(password1).style;

                    if (password1.value.length >= 6) {
                        password1.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        password1.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['password2'] = function() {

                    var password1 = document.getElementById('password1'),
                            password2 = document.getElementById('password2'),
                            tooltipStyle = getTooltip(password2).style;

                    if (password1.value === password2.value && password2.value !== '') {
                        password2.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        password2.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['section'] = function() {

                    var section = document.getElementById('section'),
                            tooltipStyle = getTooltip(section).style;

                    if (section.options[section.selectedIndex].value !== 'none') {
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                check['anneeSorti'] = function() {

                    var anneeSorti = document.getElementById('anneeSorti'),
                            tooltipStyle = getTooltip(anneeSorti).style,
                            anneeSortiValue = parseInt(anneeSorti.value);

                    if (!isNaN(anneeSortiValue) && anneeSortiValue >= 0 && anneeSortiValue <= 2015) {
                        anneeSorti.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        anneeSorti.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                // Mise en place des événements

                (function() { // Utilisation d'une fonction anonyme pour éviter les variables globales.

                    var myForm = document.getElementById('myForm'),
                            inputs = document.getElementsByTagName('input'),
                            inputsLength = inputs.length;

                    for (var i = 0; i < inputsLength; i++) {
                        if (inputs[i].type === 'text' || inputs[i].type === 'password') {

                            inputs[i].onkeyup = function() {
                                check[this.id](this.id); // « this » représente l'input actuellement modifié
                            };

                        }
                    }

                    myForm.onsubmit = function() {

                        var result = true;

                        for (var i in check) {
                            result = check[i](i) && result;
                        }

                        if (result) {
                            return result;
                        }

                        return false;

                    };

                    myForm.onreset = function() {

                        for (var i = 0; i < inputsLength; i++) {
                            if (inputs[i].type === 'text' || inputs[i].type === 'password') {
                                inputs[i].className = '';
                            }
                        }

                        deactivateTooltips();

                    };

                })();


                // Maintenant que tout est initialisé, on peut désactiver les « tooltips »

                deactivateTooltips();

            })();
        </script>
    </body>
</html>


