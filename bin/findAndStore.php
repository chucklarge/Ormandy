<?php

require_once "../Loader.php";
$u = Model_Users::find(4);
var_dump($u->getData());

$u->first_name = 'name ' . rand(0, 100);
$u->store();

var_dump($u->getData());
