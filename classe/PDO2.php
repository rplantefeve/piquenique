<?php

/**
 * Classe implémentant le singleton pour PDO
 */
class PDO2 extends PDO
{

    private static $_instance;

    /* Constructeur : héritage public obligatoire par héritage de PDO */
    public function __construct()
    {
        
    }

    // End of PDO2::__construct() */

    /* Singleton */
    public static function getInstance()
    {

        if (!isset(self::$_instance)) {

            try {
                $DSN = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
                self::$_instance = new PDO($DSN, DBUSER, DBPASSWD, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            } catch (PDOException $e) {

                echo $e;
            }
        }
        return self::$_instance;
    }

}

// end of file */
