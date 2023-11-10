<?php
function thongbao($msg)
{
    echo '<script>window.alert("' . $msg . '");</script>';
}
function curl_get($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

if (isset($_POST['napthe'])) {
    $loaithe = $_POST['loaithe'];
    $menhgia = $_POST['menhgia'];
    $seri = $_POST['seri'];
    $mathe = $_POST['mathe'];
    if (!$loaithe || !$menhgia || !$seri || !$mathe) {
        thongbao("Bạn chưa nhập đủ thông tin");
    }
    if (preg_match('/^\D/', $seri)) {
        thongbao("Seri của bạn phải là số 100% và không có chữ");
    }
    if (preg_match('/^\D/', $mathe)) {
        thongbao("Mã thẻ của bạn phải là số 100% và không có chữ");
    }
    $ranid = rand(1111111111, 9999999999);
    $partner_id = '82952574726';
    $partner_key = 'ccd53b298af043098530cc3dd5fd1351';
    $data = curl_get('https://thesieure.com/chargingws/v2?sign=' . md5($partner_key . $mathe . $seri) . '&telco=' . $loaithe . '&code=' . $mathe . '&serial=' . $seri . '&amount=' . $menhgia . '&request_id=' . $ranid . '&partner_id=' . $partner_id . '&command=charging');
    $json = json_decode($data, true);
    if ($json['status'] == 99) {
        thongbao("Gửi thẻ thành công");
    } else {
        thongbao($json['message']);
    }
}
?>