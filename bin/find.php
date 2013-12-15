<?php

require_once "../Loader.php";

$uf = new Model_UsersFinder();
$u = $uf->find(4);
var_dump($u->getData());
