<?php

    define('NP', true);
    require(__DIR__ . '/../../core/configs.php');

    $post = json_decode(file_get_contents('php://input'), true);    
    try {
        session_start();
        $user_sql = SQL()->query("select * from users where username = '".$_SESSION['user']['username']."' limit 1");
        if($user_sql != false && $user_sql->num_rows > 0){
            $user_renew = null;
            while($row = $user_sql->fetch_assoc()) {
                $user_renew = $row;
            }
            if($user_renew == null) {
                echo '{"code": "01", "text": "Thông tin tài khoản hoặc mật khẩu không chính xác."}';
                return;
            }
            if($user_renew['vnd'] < $fees['active']) {
                echo '{"code": "05", "text": "Tài khoản không đủ số dư."}';
                return;
            }
            $charge_fee = __update("users", ["kh" => 1,"vnd" => $user_renew['vnd'] - $fees['active']],["username" => $_SESSION['user']['username']]);
            if($charge_fee) {
                // $sqlInsertTrans = 'INSERT INTO transactions (user_id, vnd_before, vnd_change, vnd_after, luong_before, luong_change, luong_after, notes, created_at, updated_at) VALUES (
                //     '.$user_renew['id'].', '.$user_renew['vnd'].',  '.$fees['active'].', '.($user_renew['vnd'] - $fees['active']).', '.$user_renew['luong'].', 0, '.$user_renew['luong'].',"Kích hoạt", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP()
                // )';
                // $resultInsertTrans = SQL()->query($sqlInsertTrans);
                echo '{"code": "00", "text": "Kích hoạt tài khoản thành công."}';
            } else {
                echo '{"code": "06", "text": "Kích hoạt tài khoản thất bại. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
            }
        } else {
            echo '{"code": "01", "text": "Thông tin tài khoản hoặc mật khẩu không chính xác."}';
        }
    } catch(Exception $e) {
            echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
    }
    
?>