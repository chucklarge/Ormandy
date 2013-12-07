<?php

require_once "Loader.php";

$uf = new UsersFinder();
var_dump($uf->find(4));
/*
var_dump($uf->findAll());
var_dump($uf->findByFirstName('alex'));

$users = $uf->findAll();
foreach ($users as $user) {
    echo $user->user_id . "\t" . $user->fullName() . "\n";
}
*/
