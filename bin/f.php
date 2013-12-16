<?php

require_once "../Loader.php";

$u = Model_Users::find(4);
var_dump($u->getData());
