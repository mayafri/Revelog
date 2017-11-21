<?php

require_once 'Generic.php';

class User extends Generic {
    private $login;
    private $name;
    private $pass;

    function getLogin() {
        return $this->login;
    }

    function getName() {
        return $this->name;
    }

    function getPass() {
        return $this->pass;
    }

    /**
     * Le login doit être unique, faire entre 3 et 33 caractères et ne contenir
     * que des lettres non accentuées, des chiffres, le tiret bas ou le tiret.
     *
     * @param [string] $str
     * @return void
     */
    function setLogin($str) {
        if($str != preg_replace("/[^a-z0-9_-]/i", "", $str)) {
            throw new Exception("String contains invalid characters (a-z A-Z 0-9 _ - only).");
        }
        elseif(isStringRangeOk($str, 3, 33)) {
            $stmt = $this->pdo->prepare("SELECT count(*) FROM revelog_Users WHERE login=?");
            $stmt->execute([$str]);
            $is_login_existing = $stmt->fetchColumn();
            if($is_login_existing)
                throw new Exception("A user with this login already exists.");
            else
                $this->login = $str;
        }
    }

    /**
     * Le nom ne doit pas excéder 66 caractères.
     *
     * @param [string] $str
     * @return void
     */
    function setName($str) {
        if(isStringRangeOk($str, 0, 66)) {
            $this->name = $str;
        }
    }

    /**
     * Le mot de passe doit faire entre 10 et 1024 caractères.
     *
     * @param [string] $str
     * @return void
     */
    function setPass($str) {
        if(isStringRangeOk($str, 10, 1024)) {
            $this->pass = $str;
        }
    }

    /**
     * Relie l'objet à un utilisateur existant en le recherchant selon son
     * login unique si l'objet n'a pas déjà été relié à la base.
     *
     * @param [string] $login
     * @return void
     */
    function findByLogin($login) {
        if(isset($this->id)) {
            throw new Exception("User already defined in object.");
        }
        else {
            $stmt = $this->pdo->prepare('SELECT * FROM revelog_Users WHERE login=?');
            $stmt->execute([$login]);
            $user_data = $stmt->fetch();
            if($user_data != []) {
                $this->id = $user_data['id'];
                $this->login = $user_data['login'];
                $this->name = $user_data['name'];
                $this->pass = $user_data['pass'];
            }
            else {
                throw new Exception("Unknown user.");
            }
        }
    }

    /**
     * Sauvegarde l'objet en base de données : met à jour les données si
     * l'objet est déjà relié à la base, sinon crée un nouvel enregistrement.
     *
     * @return void
     */
    function specificSave() {
        if(isset($this->login, $this->name, $this->pass)) {
            if($this->id) {
                $this->pdo->prepare('UPDATE revelog_Users
                                     SET login=?, name=?, pass=?
                                     WHERE id=?')
                ->execute([$this->login, $this->name, $this->pass, $this->id]);
            }
            else {
                $this->pdo->prepare('INSERT INTO revelog_Users (login, name, pass)
                                     VALUES (?, ?, ?)')
                ->execute([$this->login, $this->name, $this->pass]);
                $this->id = $this->pdo->query("SELECT MAX(id)
                                               FROM revelog_Users")->fetchColumn();
            }
        }
        else {
            throw new Exception('Variables login, name, pass must be defined.');
        }
    }

    /**
     * Détruit l'objet de la base de données.
     *
     * @return void
     */
    function specificDestroy() {
        $stmt = $this->pdo->prepare('DELETE FROM revelog_Users WHERE id=?');
        $stmt->execute([$this->id]);
    }
}