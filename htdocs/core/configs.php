<?php
ob_start();
defined('NP') or header('location: /');
//gọi đến file functrion.php
require(__DIR__ . '/function.php');

$isMaintained = false;

$db = [
    'server' => 'localhost', //mặc định là localhost
    'user' => 'root', //tài khoản database
    'password' => '', //mật khẩu database
    'name' => 'nsoz' //tên bảng database
];

$w_api_recaptcha = "6LdCansoAAAAAAJYnn8dbSqliVbzWFcQG9lOK0Apg";
$w_api_recaptcha_private = "6LdCansoAAAAAKPR5OqFv68ZKWbjOMCIM44TMf-8";


$mailInfor = [
    "username" => "",
    "password" => "",
    "from" => "nsochen.pro"
];

$list_recharge_price_momo = [
    [
        "amount" => 10000,
        "bonus" => 25
    ],
    [
        "amount" => 50000,
        "bonus" => 25
    ],
    [
        "amount" => 100000,
        "bonus" => 25
    ],
    [
        "amount" => 200000,
        "bonus" => 25
    ],
    [
        "amount" => 500000,
        "bonus" => 25
    ],
    [
        "amount" => 1000000,
        "bonus" => 27
    ],
    [
        "amount" => 2000000,
        "bonus" => 30
    ],
    [
        "amount" => 5000000,
        "bonus" => 36
    ],
    [
        "amount" => 10000000,
        "bonus" => 45
    ],
];

$configNapTien = [
    'atm' => [
        'nganhang' => '', //hổ trợ mb bank, vcb
        'chutaikhoan' => '', //chủ tài khoản atm mà bạn sử dụng
        'sotaikhoan' => '', //số tài khoản atm bạn sử dụng
        'apikey' => '', //Api key mà api.web2m.com cung cấp cho bạn
        'matkhau' => '' //Mật khẩu vietcombank của bạn
        //config apikey,matkhau mới chạy được autobank
    ],
    'momo' => [
        'chutaikhoan' => '', //tên chủ tài khoản ví momo
        'sotaikhoan' => '', //số điện thoại momo,
        'apikey' => '' //Api key mà api.web2m.com cung cấp cho bạn,
        //config apikey mới chạy được autobank
    ]
];

$fees = [
    'active' => 20000,
];

$bonusDoiLuong = [
    'bonus' => 0
];

$configDoiLuong = [
    [
        'pCoin' => 10000,
        'luong' => 11200,
    ],
    [
        'pCoin' => 20000,
        'luong' => 21200,
    ],
    [
        'pCoin' => 50000,
        'luong' => 51200,
    ],
    [
        'pCoin' => 100000,
        'luong' => 112000,
    ],
    [
        'pCoin' => 200000,
        'luong' => 212000,
    ],
    [
        'pCoin' => 500000,
        'luong' => 512000,
    ],
    [
        'pCoin' => 1000000,
        'luong' => 1120000,
    ],
    [
        'pCoin' => 2000000,
        'luong' => 2120000,
    ],
    [
        'pCoin' => 5000000,
        'luong' => 5120000,
    ],
];

// config nap the dien thoai
$configChargingCard = [
    'partnerID' => "",
    'partnerKey' => "",
];
