<?php

    define('NP', true);
    require(__DIR__ . '/../../core/configs.php');

    $post = json_decode(file_get_contents('php://input'), true);
    //Something to write to txt log
    $log  = "Host: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Content REGISTER: ".json_encode($post).PHP_EOL.
            "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
    
    $username = $post['username'];
    $password = $post['password'];
    $phone = $post['phone'];
    $mail = $post['email'];
	
    try {
		
        $checkUser = SQL()->query("select username from users where username = '".$username."' limit 1");
        if($checkUser != false && $checkUser->num_rows > 0){
            echo '{"code": "02", "text": "Tên đăng nhập đã tồn tại trên hệ thống."}';
            return;
        }
		
		$checkEmail = SQL()->query("select email from users where email = '".$mail."' limit 1");
        if($checkEmail != false && $checkEmail->num_rows > 0){
            echo '{"code": "04", "text": "Email đã tồn tại trên hệ thống."}';
            return;
        }

        $sql = SQL()->query("insert into `users` (`username`, `password`, `phone`,`email`, `status`, `activated`, `kh`, `created_at`) values ('".$username."' , '".$password."' , '".$phone."' , '" . $mail . "',1,1, 0,'".date("Y-m-d H:i:s")."')");


        if($sql) {
            echo '{"code": "00", "text": "Tạo tài khoản thành công."}';
        } else {
            echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
        }
    } catch(Exception $e) {
        echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    }

?>