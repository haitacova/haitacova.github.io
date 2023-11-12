<?php

    define('NP', true);
    require(__DIR__ . '/../../core/configs.php');

    $post = json_decode(file_get_contents('php://input'), true);
    //Something to write to txt log
    $log  = "Host: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Content LOGIN: ".json_encode($post).PHP_EOL.
            "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
    $username = $post['username'];
    $password = $post['password'];
    
    try {
        $user = SQL()->query("select * from users where username = '".$username."' and password = '".$password."' limit 1");
        if($user != false && $user->num_rows > 0){
            while($row = $user->fetch_assoc()) {
                session_start();
                $_SESSION['user'] = $row;
                $_SESSION['isLogged'] = true;
            }
            echo '{"code": "00", "text": "Đăng nhập thành công."}';
        } else {
            echo '{"code": "01", "text": "Thông tin tài khoản hoặc mật khẩu không chính xác."}';
        }
    } catch(Exception $e) {
            echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    }
    
?>