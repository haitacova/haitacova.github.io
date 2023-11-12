<?php
    define('NP', true);
    require(__DIR__ . '/../../core/configs.php');
    $post = json_decode(file_get_contents('php://input'), true);
    //Something to write to txt log
    $log  = "Host: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Content FORGOT: ".json_encode($post).PHP_EOL.
            "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
    
    
    $username = $post['username'];
    $code = $post['code'];
    $type = $post['type'];
    $password = $post['newPass'];
    // try {
    //     $checkUser = SQL()->query("select username from users where username = '".$username."' and phone = '".$phone."' limit 1");
    //     // $phoneNumber = str_replace('+84','0',$phone);
    //     // $checkUser = SQL()->query("select username from users where username = '" . $username . "' and phone = '" . $phoneNumber . "' limit 1");
        
    //     if($checkUser == false || $checkUser->num_rows < 1){
    //         echo '{"code": "04", "text": "Thông tin không tồn tại trên hệ thống."}';
    //         return;
    //     } else if($type == "check") {
    //         echo('{"code": "00", "text": "Thông tin chính xác."}');
    //     } else if($type == "otp") {
    //         $sql = SQL()->query("update `users` set `password` = '".$code."', `updated_at` = '".date("Y-m-d H:i:s")."' where `username` = '".$username."' and `phone` = '".$phone."'");
    
    //         if($sql) {
    //             echo '{"code": "00", "text": "Cấp lại mật khẩu thành công."}';
    //         } else {
    //             echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    //         }
    //     }
    // } catch(Exception $e) {
    //     echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    // }
    try {
        $sql = "select username from users where username = '" . $username . "' limit 1";
        $checkUser = SQL()->query($sql);

        if ($checkUser == false || $checkUser->num_rows < 1) {
            echo '{"code": "04", "text": "Thông tin không tồn tại trên hệ thống."}';
            return;
        } else {
            $sqlUpdate = SQL()->query("update `users` set `password` = '" . $password . "',`tempCode` = NULL, `updated_at` = '" . date("Y-m-d H:i:s") . "' where `username` = '" . $username . "'");
            if ($sqlUpdate) {
                echo '{"code": "00", "text": "Cấp lại mật khẩu thành công."}';
            } else {
                echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
            }
            return;
        }
    } catch (Exception $e) {
        echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    }
?>