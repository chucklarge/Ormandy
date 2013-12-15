<?php

require_once "../Loader.php";

$uf = new Model_UsersFinder();
$u = $uf->find(1386972656);
var_dump($u->getData());
$u->delete();
var_dump($u->getData());
