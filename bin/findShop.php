<?php

require_once "../Loader.php";

$s = Model_Shops::find(2342);

var_dump($s->getData());
var_dump($s->User()->getData());
