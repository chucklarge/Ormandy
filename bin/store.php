<?php

require_once "../Loader.php";

$u = new Model_Users();
$u->user_id = time();
$u->first_name = 'Sweet ' . rand(0, 100);
$u->last_name = 'Action ' . rand(0, 100);
$u->email = 'sa' . rand(0, 100) . '@email.com';
$u->create_date = time();
$u->update_date = time();
$u->store();

