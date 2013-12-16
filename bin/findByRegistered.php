<?php

require_once "../Loader.php";

$uf = new Model_Users();
$u = $uf->findByFirstName('chuck');
var_dump($u->getData());
