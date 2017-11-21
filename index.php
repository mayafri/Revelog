<?php

require_once 'models/User.php';

$toto = new User();
$toto->setLogin('tottoo');
$toto->setName('George Abitbol');
$toto->setPass('abcdesdfsdf');
$toto->destroy();

?>
