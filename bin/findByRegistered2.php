<?php

require_once "../Loader.php";

$uf = new Model_Shops();

$u1 = $uf->findByUserId(3);
var_dump($u1);

$u2 = $uf->findByUserId(5);
var_dump($u2->getData());

