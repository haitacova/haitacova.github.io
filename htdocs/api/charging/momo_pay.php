<?php

define('NP', true);
require(__DIR__ . '/../../core/configs.php');
$post = json_decode(file_get_contents('php://input'), true);
$choose = $post['pcoin'];
try {
    session_start();
    $user = $_SESSION['user'];
    $sqlUs = 'SELECT username FROM users WHERE id=' . $user['id'] . ' LIMIT 1';
    $resultUs = SQL()->query($sqlUs);
    $userDB = $resultUs->fetch_assoc();
    $username = $userDB['username'];
    if(!isset($list_recharge_price_momo[$choose])) {
        echo '{"code": "01", "text": "Bạn chưa chọn số tiền nạp"}';
    }
    if(isset($list_recharge_price_momo[$choose]) && isset($configNapTien['momo']['sotaikhoan'])){
        $amount = $list_recharge_price_momo[$choose]['amount'];
        $acctNum = $configNapTien['momo']['sotaikhoan'];
        $qr = getQrMomoPayment($username, $amount, $acctNum);
        $link = getLinkMomoPayment($username, $amount, $acctNum);
        echo '{"code": "00", "text": "Lấy thông tin thanh toán thành công.", "qr_pay": "'.$qr.'", "link_pay": "'.$link.'"}';
        return;
    }
    echo '{"code": "01", "text": "Thanh toán momo lỗi. Bạn vui lòng chọn phương thức thanh toán khác"}';
} catch (Exception $e) {
    echo '{"code": "99", "text": "Hệ thống gặp lỗi. Vui lòng liên hệ quản trị viên để được hỗ trợ."}';
}