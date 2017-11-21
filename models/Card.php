<?php

require_once 'Generic.php';

class Card extends Generic {
    private $title;
    private $creation_date;
    private $content;
    private $narration;
    private $emotion;
    private $lucidity;
    private $share;
    private $fk_user;

    function getTitle() {
        return $this->title;
    }
    function getCreationDate() {
        return $this->creation_date;
    }
    function getContent() {
        return $this->content;
    }
    function getNarration() {
        return $this->narration;
    }
    function getEmotion() {
        return $this->emotion;
    }
    function getLucidity() {
        return $this->lucidity;
    }
    function getShare() {
        return $this->share;
    }
    function getUserId() {
        return $this->fk_user;
    }

    function setTitle($str) {
        $str = trim($str);
        if(isStringRangeOk($str, 0, 500)) {
            $this->title = $str;
        }
    }
    function setContent($str) {
        $str = trim($str);
        if(isStringRangeOk($str, 0, 60000)) {
            $this->content = $str;
        }
    }
    function setNarration($choice) {
        if(isChoiceAvailable($choice, ['first', 'third', 'confused'])) {
            $this->narration = $choice;
        }
    }
    function setEmotion($choice) {
        if(isChoiceAvailable($choice, ['positive', 'negative', 'confused'])) {
            $this->emotion = $choice;
        }
    }
    function setLucidity($choice) {
        if(isChoiceAvailable($choice, ['yes', 'no', 'confused'])) {
            $this->lucidity = $choice;
        }
    }
    function setShare($choice) {
        if(isChoiceAvailable($choice, ['private', 'public'])) {
            $this->share = $choice;
        }
    }
    function setUserId($id) {
        $stmt = $this->pdo->prepare('SELECT id FROM revelog_Users WHERE id=?');
        $stmt->execute([$id]);
        $user_data = $stmt->fetch();
        if($user_data != []) {
            $this->fk_user = $user_data['id'];
        }
        else {
            throw new Exception("Unknown user.");
        }
    }

    function find() {
        
    }

    function specificSave() {

    }
    function specificDestroy() {

    }
}