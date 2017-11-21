<?php

require_once 'util.php';

abstract class Generic {
    private $is_destroyed = false;
    protected $id;
    protected $pdo;

    /**
     * Fonction interne de sauvegarde de l'objet dans la base de données.
     *
     * @return void
     */
    abstract protected function specificSave();

    /**
     * Fonction interne de destruction de l'objet dans la base de données.
     *
     * @return void
     */
    abstract protected function specificDestroy();

    /**
     * Initialisation de PDO pour la base de données MySQL/MariaDB d'après les
     * infos du fichier de configuration.
     */
    function __construct() {
        $mysql_config = parse_ini_file('config/mysql.ini');
        $dsn = "mysql:host=".$mysql_config['host']
        .";dbname=".$mysql_config['db']
        .";charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dsn, $mysql_config['user'],
                             $mysql_config['pass'], $opt);
    }

    /**
     * Retourne l'identifiant unique de l'objet.
     *
     * @return $this->id
     */
    function getId() {
        return $this->id;
    }

    /**
     * Sauve l'objet en base de données en appelant specificSave(). Il est
     * impossible de sauver un objet détruit.
     * 
     * @return void
     */
    function save() {
        if($this->is_destroyed) {
            throw new Exception('Object already destroyed');
        }
        else {
            try {
                $this->specificSave();
            } catch(Exception $e) {
                throw $e;
            }
        }
    }

    /**
     * Détruit l'objet en base de données en appelant specificDestroy(). Si
     * l'objet est bien détruit, $is_destroyed est mis à true définitivement.
     *
     * @return void
     */
    function destroy() {
        if(isset($this->id)) {
            if($this->is_destroyed) {
                throw new Exception('Object already destroyed');
            }
            else {
                try {
                    $this->specificDestroy();
                    $this->is_destroyed = true;
                } catch(Exception $e) {
                    throw $e;
                }
            }
        }
    }
}