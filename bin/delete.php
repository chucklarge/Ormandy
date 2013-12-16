<?php

require_once "../Loader.php";

$u = Model_Users::find(1387136213);
var_dump($u->getData());
$u->delete();
var_dump($u->getData());
