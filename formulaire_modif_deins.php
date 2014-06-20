<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Pique-Nique</title>
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/font.css"/>
    </head>
    <body>
        <?php
        $choix = $_GET['num'];
        ?>
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

            <form id="myForm" method="post" action="traitement_modif_deins.php?num=<?php echo $_GET['num'] ?>">

                <fieldset><legend>Remplir</legend>

                    <label for="mail">E-mail : </label>
                    <input type="text" name="mail" id="mail"/>
                    <span class="tooltip">Le mail n'est pas au bon format</span>
                    <br/>

                    <label for="password">Mot de passe : </label>
                    <input type="password" name="password" id="password"/>
                    <span class="tooltip">Le mot de passe ne doit pas faire moins de 6 caractères</span>
                    <br/>


                    <?php
                    if ($choix == 1) {
                        ?>
                        <label for="participation">Voulez-vous toujours participer au pique nique?</label>
                        <select name="participation">
                            <option value="Oui">Oui</option>
                            <option value="Non">Non</option>
                        </select>
                        <?php
                    }

                    if ($choix == 2) {
                        ?>
                        <label for="supprimer">Voulez-vous être supprimé de la base de données?</label>
                        <select name="supprimer">
                            <option value="Oui">Oui</option>
                            <option value="Non">Non</option>
                        </select>
                        <?php
                    }
                    ?>
                </fieldset>
                <br/>
                <span class="form_col"></span>
                <div id="bouton">
                    <input type="submit" value="Valider" id="btn"/> <input type="reset" value="Réinitialiser" id="btn"/>
                </div>


            </form>

        </section>
        <script>
            document.getElementById('mail').onpaste = function () {
                alert('Merci de ne pas copier/coller');        // on prévient
                return false;        // on empêche
            };
        </script>
        <script>
            document.getElementById('password').onpaste = function () {
                alert('Merci de ne pas copier/coller');        // on prévient
                return false;        // on empêche
            };
        </script>

        <script>
            (function () { // On utilise une IEF pour ne pas polluer l'espace global

                // Fonction de désactivation de l'affichage des « tooltips »

                function deactivateTooltips()
                {
                    var spans = document.getElementsByTagName('span'),
                            spansLength = spans.length;

                    for (var i = 0; i < spansLength; i++) {
                        if (spans[i].className === 'tooltip') {
                            spans[i].style.display = 'none';
                        }
                    }

                }


                // La fonction ci-dessous permet de récupérer la « tooltip » qui correspond à notre input

                function getTooltip(element)
                {
                    while (element = element.nextSibling) {
                        if (element.className === 'tooltip') {
                            return element;
                        }
                    }

                    return false;

                }


                // Fonctions de vérification du formulaire, elles renvoient « true » si tout est OK

                var check = {}; // On met toutes nos fonctions dans un objet littéral

                check['mail'] = function () {

                    var mail = document.getElementById('mail'),
                            tooltipStyle = getTooltip(mail).style;
                    var regex = /^[a-zA-Z0-9._-]+@[a-z._-]{2,}\.[a-z]{2,4}$/;

                    if (regex.test(mail.value)) {
                        mail.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        mail.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };


                check['password'] = function () {

                    var password = document.getElementById('password'),
                            tooltipStyle = getTooltip(password).style;

                    if (password.value.length >= 6) {
                        password.className = 'correct';
                        tooltipStyle.display = 'none';
                        return true;
                    } else {
                        password.className = 'incorrect';
                        tooltipStyle.display = 'inline-block';
                        return false;
                    }

                };

                // Mise en place des événements

                (function () { // Utilisation d'une fonction anonyme pour éviter les variables globales.

                    var myForm = document.getElementById('myForm'),
                            inputs = document.getElementsByTagName('input'),
                            inputsLength = inputs.length;

                    for (var i = 0; i < 2; i++) {
                        if (inputs[i].type === 'text' || inputs[i].type === 'password') {

                            inputs[i].onkeyup = function () {
                                check[this.id](this.id); // « this » représente l'input actuellement modifié
                            };

                        }
                    }

                    myForm.onsubmit = function () {

                        var result = true;

                        for (var i in check) {
                            result = check[i](i) && result;
                        }

                        if (result) {
                            return result;
                        }

                        return false;

                    };

                    myForm.onreset = function () {

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
