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
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Nạp thẻ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row" style="margin-top: 50px;">
            <div class="col-md-8" style="float:none;margin:0 auto;">
                <form method="POST">
                    <div class="form-group">
                        <label>Loại thẻ:</label>
                        <select class="form-control" name="loaithe">
                            <option value="">Chọn loại thẻ</option>
                            <option value="VIETTEL">Viettel</option>
                            <option value="MOBIFONE">Mobifone</option>
                            <option value="VINAPHONE">Vinaphone</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mệnh giá:</label>
                        <select class="form-control" name="menhgia">
                            <option value="">Chọn mệnh giá</option>
                            <option value="10000">10.000</option>
                            <option value="20000">20.000</option>
                            <option value="30000">30.000</option>
                            <option value="50000">50.000</option>
                            <option value="100000">100.000</option>
                            <option value="200000">200.000</option>
                            <option value="300000">300.000</option>
                            <option value="500000">500.000</option>
                            <option value="1000000">1.000.000</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số seri:</label>
                        <input type="text" class="form-control" name="seri" />
                    </div>
                    <div class="form-group">
                        <label>Mã thẻ:</label>
                        <input type="text" class="form-control" name="mathe" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" name="napthe">NẠP NGAY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
</body>

</html>