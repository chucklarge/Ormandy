<?php

require_once "../../Loader.php";

$sf = new Model_ShopsFinder();
$s = $sf->find(2342);

var_dump($s->getData());
var_dump($s->User()->getData());
