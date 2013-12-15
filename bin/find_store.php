<?php

require_once "../Loader.php";
$uf = new Model_UsersFinder();
$u = $uf->find(4);
var_dump($u->getData());

$u->first_name = 'name ' . rand(0, 100);
$u->store();

var_dump($u->getData());
