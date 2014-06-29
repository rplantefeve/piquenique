<?php

namespace Edu\Stmichel\Piquenique\Includes;

use PDO;

require_once 'config/config.inc.php';
require_once 'Utils.php';

class DB
{

    // instance unique de la classe (singleton)
    private static $instance = null;
    // instance de la classe PDO
    private $PDOInstance = null;

    /*
     * Méthode utile pour récupérer le singleton depuis le programme appelant
     */
    public static function getInstance()
    {
        // si l'instance n'a encore jamais été instanciée
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        // on retourne l'instance de la classe
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    /*
     * Constructeur de la classe qui initialise la connexion
     */
    private function __construct()
    {
        $dataSourceName = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";
        // on appelle le constructeur de la classe PDO
        $this->PDOInstance = new PDO($dataSourceName, DBUSER, DBPASSWD, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    /**
     * Exécute une requête SQL
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres de la requête
     * @return PDOStatement Résultats de la requête
     */
    public function query($sql, $params = null)
    {
        // si pas de paramètres
        if ($params == null) {
            // exécution directe
            $resultat = $this->PDOInstance->query($sql);
        } else {
            // requête préparée
            $resultat = $this->PDOInstance->prepare($sql);
            $resultat->execute($params);
        }
        return $resultat;
    }

    /*
     * Fonctions utilitaires
     */
    /**
     * Retourne les lignes d'enregistrements sous forme de tableau associatif
     * Ici, on aura N lignes, N colonnes
     * @param string $unSQLSelect La requête SQL
     * @param array $parametres Les éventuels paramètres de la requête
     * @param boolean $estVisible (visualisation du résultat)
     * @return array[][] ou null
     */
    public function extraireNxN($unSQLSelect, $parametres = null, $estVisible = false)
    {
        // tableau des résultats
        $tableau = array();
        // résultat de la requête
        $resultat = $this->query($unSQLSelect, $parametres);

        // boucle de construction du tableau de résultats
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $tableau[] = $ligne;
        }
        unset($resultat);

        // si la tableau ne contient pas d'élément
        if (count($tableau) == 0) {
            $tableau = null;
        }

        // si l'on souhaite afficher le contenu du tableau (DEBUG MODE)
        if ($estVisible) {
            Utils::afficherResultat($tableau, $unSQLSelect);
        }

        // on retourne le tableau de résultats
        return $tableau;
    }

    /**
     * Retourne une ligne d'enregistrement sous forme de tableau associatif
     * @param string $unSQLSelect
     * @param array $parametres Tableau des paramètres de la requête
     * @param boolean $estVisible (visualisation du résultat)
     * @return array[] ou null
     */
    public function extraire1xN($unSQLSelect, $parametres = null, $estVisible = false)
    {
        $result = self::extraireNxN($unSQLSelect, $parametres);
        if (isset($result[0])) {
            $result = $result[0];
        }
        if ($estVisible) {
            Utils::afficherResultat($result, $unSQLSelect);
        }
        return $result;
    }

}
