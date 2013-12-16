<?php

require_once "../Loader.php";

$shops = Model_Shops::findAll();
foreach ($shops as $shop) {
    $user = $shop->User();
    echo sprintf("%d\t%s\t%d\t%s\n",
        $user->user_id, $user->fullName(),
        $shop->shop_id, $shop->shop_name
    );
}

