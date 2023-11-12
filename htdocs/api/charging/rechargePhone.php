<?php

define('NP', true);
require(__DIR__ . '/../../core/configs.php');
require(__DIR__ . '/requestCard.php');

$post = json_decode(file_get_contents('php://input'), true);
//Something to write to txt log
$log = "Host: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
    "Content LOGIN: " . json_encode($post) . PHP_EOL .
    "-------------------------" . PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);

// $card = new Card();
$rqCard = new RequestCard();
$provider = $post['provider'];
$amount = $post['amount'];
$code = $post['code'];
$serial = $post['serial'];


try {
    if (checkInDB($code, $serial)) {
        $rqId = time();

        $return = $rqCard->cardCharging($rqId,$serial, $code, $provider, $amount, $configChargingCard['partnerID'], convertMd5($configChargingCard['partnerKey'], $code, $serial), 'charging');
        if ($return['code'] === 99) {
            insertToDB($rqId, $serial, $code, $provider, $amount, $return['amount']);
        } else {
            echo '{"code": "' . $return['code'] . '", "text": "Mã thẻ hoặc số serial không hợp lệ."}';
            return;
        }
    } else {
        echo '{"code": "01", "text": "Mã thẻ hoặc số serial đã được sử dụng trong hệ thống."}';
        return;
    }

} catch (Exception $e) {
    echo '{"code": "01", "text": "Error."}';
}

function insertToDB($rqId, $serial, $code, $card_type, $amount, $real_value)
{

    try {
        session_start();
        $user = $_SESSION['user'];
        $sql = '
    INSERT INTO `charging_orders` (`user_id`, `request_id`, `code`, `serial`, `telco`,  `declared_value`,`real_value`, `fee`, `status`, `description`, `extra`, `notes`, `created_at`, `updated_at`) VALUES
    (' . $user['id'] . ', '.$rqId.', ' . $code . ', ' . $serial . ', "' . $card_type . '", "' . $amount . '",  "' . $real_value . '", ' . round($real_value / $amount, 2) . ', "PENDING", "Nạp thẻ cào", NULL, NULL, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())
    ';
        $rowIs = SQL()->query($sql);
        if ($rowIs) {
            echo '{"code": "00", "text": "Đang xử lý."}';
            return;
        } else {
            echo '{"code": "01", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
            return;
        }
    } catch (Exception $e) {
        echo '{"code": "01", "text": "Error"}';
    }
}
function convertMd5($key, $code, $sr)
{
    return md5($key . $code . $sr);
}

function checkInDB($cd, $sr)
{
    $sqlSl = 'SELECT id FROM charging_orders WHERE code = "' . $cd . '" OR serial = "' . $sr . '" ';
    $resultSl = SQL()->query($sqlSl);
    if ($resultSl != false && $resultSl->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}