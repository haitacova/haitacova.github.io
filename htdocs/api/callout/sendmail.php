<?php
define('NP', true);
require(__DIR__ . '/../../core/configs.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$post = json_decode(file_get_contents('php://input'), true);

$phpMailer = new PHPMailer();

$username = $post["username"];
$mail = $post["mail"];
$code = $post["code"];
$type = $post["type"];
$key = $post["key"];
if ($type == 'send') {
    try {
        $sql = "select username, updated_at, tempCode from users where username = '" . $username . "'  limit 1";
        $checkUser = SQL()->query($sql);

        if ($checkUser == false || $checkUser->num_rows < 1) {
            echo '{"code": "04", "text": "Thông tin không tồn tại trên hệ thống."}';
            return;
        }else {
            $objUser =  $checkUser->fetch_assoc();
            $tempCodeDB = $objUser['tempCode'] ?? null;
            $updatedAt =  $objUser['updated_at'] ?? null;
    
            $diff = 0;
            if(!is_null($updatedAt)){
                $updatedAt = new DateTime(strval($updatedAt));
                $now = new DateTime();
                $diff = $updatedAt->diff($now)->i + $updatedAt->diff($now)->h*60;
            }
            if( $diff < 5 && !is_null($tempCodeDB) && strstr($objUser['tempCode'],$key)){
                echo '{"code": "05", "text": "Vui lòng truy cập mail để xem mã OTP hoặc chờ 5 phút để gửi lại."}';
                return;
            }else {
                try {
                    $nbRandom = rand(10000, 99999);
                    $tempCode = '';
                    switch ($key) {
                        case 'C':
                            $tempCode = 'C' . $nbRandom;
                            break;
                        case 'P':
                            $tempCode = 'P' . $nbRandom;
                            break;
                        case 'F':
                            $tempCode = 'F' . $nbRandom;
                            break;
                    }
                    // Settings
                    $phpMailer->IsSMTP();
                    $phpMailer->CharSet = 'UTF-8';
    
                    $phpMailer->Host = "smtp.gmail.com"; // SMTP server example
                    $phpMailer->SMTPDebug = 0; // enables SMTP debug information (for testing)
                    $phpMailer->SMTPAuth = true; // enable SMTP authentication
                    $phpMailer->Port = 25; // set the SMTP port for the GMAIL server
                    $phpMailer->Username = $mailInfor['username']; // SMTP account username example
                    $phpMailer->Password = $mailInfor['password']; // SMTP account password example
    
                    // Content
                    $phpMailer->setFrom($mailInfor['from']);
                    $phpMailer->addAddress($mail);
    
                    $phpMailer->isHTML(true); // Set email format to HTML
                    $phpMailer->Subject = 'Verify account from '.$mailInfor['from'].'';
                    $phpMailer->Body = 'Mã OTP của bạn là <b>'.$tempCode.'</b> <div><b>Lưu ý: </b>Mã sẽ hết hạn sau 5 phút.</div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        From '.$mailInfor['from'].'';
                    $phpMailer->AltBody = 'From '.$mailInfor['from'].'';
    
                    $phpMailer->send();
                    $sqlUpdate = SQL()->query("update `users` set `tempCode` = '" . $tempCode . "', `updated_at` = '" . date("Y-m-d H:i:s") . "' where `username` = '" . $username . "'");
                    echo ('{"code": "00", "text": "Chúng tôi đã gửi mail xác minh về địa chỉ ' . $mail . '"}');
                    return;
                } catch (Exception $e) {
                    echo '{"code": "01", "text":"Có lỗi xảy ra"}';
                    return;
                }
            }
        }
         

    } catch (Exception $e) {
        echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
        return;
    }
} else if($type="check"){
    $sql = "select username, updated_at from users where username = '" . $username . "' and tempCode = '" . $code . "' limit 1";
    $checkUser = SQL()->query($sql);
    if ($checkUser == false || $checkUser->num_rows < 1) {
        echo '{"code": "04", "text": "Thông tin không tồn tại trên hệ thống."}';
        return;
    } else {
        $updatedAt = new DateTime(strval($checkUser->fetch_assoc()['updated_at']));
        $now = new DateTime();
        $diff = $updatedAt->diff($now)->i + $updatedAt->diff($now)->h*60;
        if($diff > 300){
            echo '{"code": "05", "text": "Mã OTP đã hết hạn. Vui lòng bấm gửi OTP để nhận mã mới."}';
            return;
        }
        else{
            echo '{"code": "00", "text": ""}';
        }
        return;
    }
}
?>