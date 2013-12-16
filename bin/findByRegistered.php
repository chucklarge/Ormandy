<?php

require_once "../Loader.php";

$uf = new Model_Users();
$us = $uf->findByFirstName('a');
var_dump($us);
foreach ($us as $u) {
    var_dump($u->getData());
}
