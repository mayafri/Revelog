<?php

function isStringRangeOk($str, $min, $max) {
    if(mb_strlen($str) < $min || mb_strlen($str) > $max) {
        throw new Exception("String length out of range "+$min+"-"+$max+"c.");
    }
    else {
        return true;
    }
}

function isChoiceAvailable($choice, $options) {
    if(in_array($choice, $options)) {
        return true;
    }
    else {
        throw new Exception("This choice is unavailable.");
    }
}