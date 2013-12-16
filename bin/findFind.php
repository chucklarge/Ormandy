<?php

require_once "../Loader.php";

$u1 = Model_Users::find(4);
var_dump($u1->getData());

$u2 = Model_Users::find(2);
var_dump($u2->getData());

var_dump($u1->getData());
