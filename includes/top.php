<?php
require_once 'includes/utilisateur.php';



// On teste si un utilisateur est connecté
$areCredentialsOK = true;
if (!isset($isAUserIsLogged)) {
    $isAUserIsLogged = isAUserIsLogged($areCredentialsOK);
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title><?= $title ?></title>
        <!--
        <link rel="stylesheet" href="css/style.css"/>
        <link rel="stylesheet" href="css/font.css"/>
        -->
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
        <link href="css/bootstrap-theme.min.css" rel="stylesheet"/>
        <!-- Styles additionnels -->
        <link href="css/additional-styles.css" rel="stylesheet"/>
        <link href="css/style_modified.css" rel="stylesheet"/>
    </head>
    <body role="document">
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- le hidden-txt provoque des bugs graphiques trop long à résoudre ^^ -->
                    <a class="navbar-brand navbar-brand-logo" href="index.php"><p class="hidden-txt">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li<?php
                        if (strrpos(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), "index")) {
                            echo ' class="active"';
                        }
                        ?>><a href="index.php">Accueil</a></li>
                        <li<?php
                        if (strrpos(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), "news")) {
                            echo ' class="active"';
                        }
                        ?>><a href="news.php">News</a></li>
                        <li<?php
                        if (strrpos(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), "participation")) {
                            echo ' class="active"';
                        } else {
                            echo ' class="dropdown"';
                        }
                        ?>>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Le pique-nique <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="formulaire_enregistrer_participation.php">Participer</a></li>
                                <li><a href="formulaire_annuler_participation.php">Ne plus participer</a></li>
                            </ul>
                        </li>
                        <li<?php
                        if (strrpos(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL), "inscription")) {
                            echo ' class="active"';
                        } else {
                            echo ' class="dropdown"';
                        }
                        ?>>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Le registre des anciens <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="formulaire_inscription.php">S'inscrire</a></li>
                                <li><a href="formulaire_desinscription.php">Se désinscrire</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                    // Si pas d'utilisateur connecté
                    if (!$isAUserIsLogged) {
                        // on affiche le formulaire de connexion
                        ?>
                        <form class="navbar-form navbar-right" role="form" method="POST">
                            <div class="form-group<?php
                            if (!$areCredentialsOK) {
                                echo ' has-error';
                            }
                            ?>">
                                <input name="email" type="text" placeholder="Email" class="form-control"<?php
                                if (!$areCredentialsOK) {
                                    echo' value="' . filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) . '"';
                                }
                                ?>>
                            </div>
                            <div class="form-group<?php
                            if (!$areCredentialsOK) {
                                echo ' has-error';
                            }
                            ?>">
                                <input name="password" type="password" placeholder="Mot de passe" class="form-control">
                            </div>
                            <input name="submittedForm" type="hidden" value="connectionForm"/>
                            <button type="submit" class="btn btn-success">Se connecter</button>
                            <!--<button id="example" type="button" class="btn btn-lg btn-danger" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click to toggle popover</button>-->
                        </form>
                        <?php
                        if (!$areCredentialsOK) {
                            ?>
                            <span class="tooltip2 navbar-right">Informations de connexion incorrectes</span>
                            <?php
                        }
                    }
                    // sinon, on affiche un bouton pour se déconnecter
                    else {
                        ?>
                        <form class="navbar-form navbar-right" role="form" method="POST">
                            <input name="submittedForm" type="hidden" value="disconnectionForm"/>
                            <button type="submit" class="btn btn-danger">Se déconnecter</button>
                        </form>
                        <?php
                    }
                    ?>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container theme-showcase" role="main">
