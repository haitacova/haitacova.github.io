<?php

    define('NP', true);
    require(__DIR__ . '/../../core/configs.php');
    $post = json_decode(file_get_contents('php://input'), true);

    //Something to write to txt log
    $log  = "Host: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Content CHANGE PASS: ".json_encode($post).PHP_EOL.
            "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);

    $username = $post['username'];
    $current_pass = $post['password'];
    $new_password = $post['new_password'];

    try {
        $checkUser = SQL()->query("select username from users where username = '".$username."' and password = '".$current_pass."' limit 1");

        if($checkUser == false || $checkUser->num_rows < 1){
            echo '{"code": "04", "text": "Mật khẩu không đúng."}';
            return;
        } else {
            $sql = SQL()->query("update `users` set `password` = '".$new_password."' where `username` = '".$username."' and `password` = '".$current_pass."'");

            if($sql) {
                echo '{"code": "00", "text": "Thay đổi mật khẩu thành công. Bạn cần đăng nhập lại"}';
                session_start();
                session_destroy();
            } else {
                echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
            }
        }
    } catch(Exception $e) {
        echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    }

?>