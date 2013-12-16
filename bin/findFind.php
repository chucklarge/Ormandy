<?php

require_once "../Loader.php";

$uf = new Model_Users();
$u1 = $uf->find(4);
var_dump($u1->getData());

$u2 = $uf->find(2);
var_dump($u1->getData());

var_dump($u1->getData());
