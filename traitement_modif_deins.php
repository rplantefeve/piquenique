<!DOCTYPE html>


<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Pique-Nique</title>
        <link rel="stylesheet" href="css/style.css"/>
    </head>
    <body>

        <?php
        require_once('config/config.inc.php');
        require_once('classe/PDO2.php');

        try {
            $bdd = PDO2::getInstance();
        } catch (Exception $e) {
            die('Erreur:' . $e->getMessage());
        }


        if (!isset($_POST['participation']) || !isset($_POST['supprimer'])) {
            if (!isset($_POST['participation'])) {
                $participation = 'null';
                $supprimer = $_POST['supprimer'];
            }
            if (isset($_POST['participation'])) {
                $participation = $_POST['participation'];
                $supprimer = 'null';
            }

            if (!isset($_POST['supprimer'])) {
                $supprimer = 'null';
                $participation = $_POST['participation'];
            }
            if (isset($_POST['supprimer'])) {
                $supprimer = $_POST['supprimer'];
                $participation = 'null';
            }
        }

        $mail = $_POST['mail'];
        $password = $_POST['password'];


        $sqlMailPassword = "SELECT mail, password FROM  `participant` WHERE mail = '$mail' AND password= '$password';";
        $compare = $bdd->query($sqlMailPassword);

        $resultat = $compare->fetch();

        if ($resultat['mail'] == "") {
            ?>

            <p>
                La saisie ne correspond à aucun compte.  
                <br/>
                <br/> 
                Vous allez être redirigé...	
                <?php
                if ($participation != null) {
                    ?>
                    <meta http-equiv='refresh' content='2;URL=formulaire_modif_deins.php?num=1'>
                    <?php
                }
                if ($supprimer != null) {
                    ?>
                    <meta http-equiv='refresh' content='2;URL=formulaire_modif_deins.php?num=2'>
                    <?php
                }
                ?>

            </p>

            <?php
        } else {
            if (($participation == 'Oui' || $participation == 'Non') && $supprimer == 'null') {
                $sql = "UPDATE `piquenique`.`participant` SET `participant`.`participation` = '$participation' WHERE `participant`.`mail` = '$mail' AND `participant`.`password` = '$password';";

                $req = $bdd->query($sql);

                if ($participation == 'Oui') {
                    ?>
                    <p>
                        Vous êtes inscrit(e) au pique nique.
                        <br/>
                        <br/> 
                        Vous allez être redirigé...	
                        <!--                        <meta http-equiv='refresh' content='2;URL=index.php'>-->
                    </p>
                    <?php
                }
                if ($participation == 'Non') {
                    ?>
                    <p>
                        Vous n'êtes plus inscrit(e) au pique nique.
                        <br/>
                        <br/> 
                        Vous allez être redirigé...	
                        <meta http-equiv='refresh' content='2;URL=index.php'>
                    </p>
                    <?php
                }
            }
            if ($supprimer == 'Oui') {
                $sql = "DELETE FROM `piquenique`.`participant` WHERE `participant`.`mail` = '$mail' AND `participant`.`password` = '$password';";

                $req = $bdd->query($sql);
                ?>

                <p>
                    Vous avez êtes supprimé de la base de données et vous êtes déinscrit du Pique Nique. 
                    <br/>
                    <br/> 
                    Vous allez être redirigé...	
                    <meta http-equiv='refresh' content='2;URL=index.php'>
                </p>

                <?php
            }
            if ($supprimer == 'Non') {
                ?>

                <p>
                    Vous n'êtes pas supprimé de la base de données. 
                    <br/>
                    <br/> 
                    Vous allez être redirigé...	
                    <meta http-equiv='refresh' content='2;URL=index.php'>
                </p>

                <?php
            }
        }
        ?>
    </body>
</html>