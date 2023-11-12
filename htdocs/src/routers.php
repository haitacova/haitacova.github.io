<?php

    if($page == 'post'){
        include("screens/post.php");
        return;
    }

    if($page == 'download'){
        include("screens/download.php");
        return;
    }

    if($user == null){
        include("screens/home.php");
        return;
    }

    switch ($page) {
        case 'recharge':
            include("screens/recharge.php");
            break;
        case 'ranking':
            include("screens/ranking.php");
            break;
        case 'exchange':
            include("screens/exchange.php");
            break;
        case 'user':
            include("screens/user.php");
            break;
        default:
            include("screens/home.php");
            break;
    }

?>