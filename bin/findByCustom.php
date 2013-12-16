<?php

require_once "../Loader.php";

$uf = new Model_Users();
$u = $uf->findByLastName('smith');
var_dump($u->getData());
