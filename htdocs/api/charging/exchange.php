<?php

define('NP', true);
require(__DIR__ . '/../../core/configs.php');

$post = json_decode(file_get_contents('php://input'), true);

try {
    $pCoin = $post['pcoin'];
    session_start();
    $user = $_SESSION['user'];
    $sqlUs = 'SELECT vnd, luong, online FROM users WHERE id=' . $user['id'] . ' LIMIT 1';
    $resultUs = SQL()->query($sqlUs);
    $userDB = $resultUs->fetch_assoc();
    $balanceBefore = $userDB['vnd'];
    $balanceChange = 0;
    $balanceAfter = $balanceBefore - $balanceChange;
    $luongBefore = $userDB['luong'];
    $luongChange = 0;
    $isOnline = $userDB['online'];
    if($isOnline == 1) {
        echo '{"code": "99", "text": "Bạn chưa thoát game."}';
        return;
    }

    if ($balanceBefore >= $pCoin) {
        $luongAfter = $luongBefore;
        //Sử dụng vòng lặp `foreach` để lặp qua mảng `$configDoiLuong`
        foreach($configDoiLuong as $item) {
            if($item['pCoin'] == $pCoin) {
                $luongChange = $item['luong'] + ($item['luong'] * $bonusDoiLuong['bonus'] / 100);
                $luongAfter = $luongBefore + ($item['luong'] + ($item['luong'] * $bonusDoiLuong['bonus'] / 100));
            }
        }
        $balanceAfter = $balanceBefore - $pCoin;
        //Thực thi câu lệnh SQL bằng cách gọi phương thức `query()` từ đối tượng `SQL()`
        $sql = 'UPDATE users SET luong =' . $luongAfter . ', vnd =' . $balanceAfter . ' WHERE id = ' . $user['id'] . ' ';
        $result = SQL()->query($sql);

        //in ra một chuỗi JSON chứa mã code "00" và thông báo "Bạn đã đổi PCoin thành công.
        echo '{"code": "00", "text": "Bạn đã đổi PCoin thành công."}';
    } else {
        echo '{"code": "01", "text": "Không đủ PCoin."}';
    }
} catch (Exception $e) {
    echo '{"code": "01", "text": "' . $e . '"}';
}