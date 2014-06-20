<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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
            <img src="images/paquier1.jpg" alt="Baniere"/>
            <h4>Rendez-vous!</h4>
            <p>
                On vous attend en famille le 13 septembre à partir de 11 heures aux Puisots.<br/>
            </p>
            <h5>Pour quoi faire ?</h5>
            <p>
                - Manger (c’est un pique-nique, chacun apporte le sien)<br/>
                - Se retrouver par promotion (ou pas) et constater comme on n’a pas du tout changé !<br/>
                - Parler emplois, stages, alternance<br/>
                - Parler vie, voyages, passions, enfants, …<br/>
            </p>
            <h5>Qui est convié ?</h5>
            <p>
                - Les anciens élèves des BTS IG, IRIS, SIO des lycées ECA et Saint-Michel.<br/>
                - Les professeurs ( les anciens et les modernes)<br/>
                <br/>
                On espère avoir beau temps mais si ce n’est pas le cas, nous aurons accès aux locaux situés aux Puisots.<br/>
            </p>
            <h5>Sur ce site vous pouvez :</h5>
            <p>
                - Vous enregistrer (lien <a href="formulaire_inscription.php" id="lienTexte">enregistrement</a>) que vous veniez au pique-nique ou pas,
                ça nous permettra de mettre à jour notre base de données (et vous pourrez toujours
                supprimer les données vous concernant par le lien « <a href="formulaire_modif_deins.php?num=2" id="lienTexte">Désinscription</a> »). Vous n’êtes pas
                obligés de renseigner les informations « Entreprise ».<br/>
                - Dire si vous <a href="formulaire_modif_deins.php?num=1">participez</a> au pique-nique ou pas.<br/>
            </p>
            <p id="bureauEtudiant">
                Le Bureau des Etudiants du Lycée Saint Michel
            </p>

        </section>

    </body>
</html>
