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
                    <a class="navbar-brand" href="index.php">Lycée St-Michel</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li<?php
                        if (strrpos($_SERVER['REQUEST_URI'], "index")) {
                            echo ' class="active"';
                        }
                        ?>><a href="index.php">Accueil</a></li>
                        <li<?php
                        if (strrpos($_SERVER['REQUEST_URI'], "news")) {
                            echo ' class="active"';
                        }
                        ?>><a href="news.php">News</a></li>
                        <li<?php
                        if (strrpos($_SERVER['REQUEST_URI'], "participation")) {
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
                        if (strrpos($_SERVER['REQUEST_URI'], "inscription")) {
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
                        <li><a href="mentions_legales.php">Mentions légales</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>

        <div class="container theme-showcase" role="main">
