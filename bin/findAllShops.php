<?php

require_once "../Loader.php";

$sf = new Model_Shops();
$shops = $sf->findAll();
foreach ($shops as $shop) {
    $user = $shop->User();
    echo sprintf("%d\t%s\t%d\t%s\n",
        $user->user_id, $user->fullName(),
        $shop->shop_id, $shop->shop_name
    );
}

