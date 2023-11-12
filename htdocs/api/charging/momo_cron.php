<?php
define('NP', true);
require(__DIR__ . '/../../core/configs.php');

$log = "Host: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
    "----------MOMO CRON----------" . PHP_EOL;
$token = $configNapTien['momo']['apikey'];
$result = file_get_contents("https://api.web2m.com/historyapimomo/$token");
$result = json_decode($result, true);
foreach ($result['momoMsg']['tranList'] as $data) {
    $partnerId      = $data['partnerId'];               // SỐ ĐIỆN THOẠI CHUYỂN
    $comment        = $data['comment'];                 // NỘI DUNG CHUYỂN TIỀN
    $tranId         = $data['tranId'];                  // MÃ GIAO DỊCH
    $partnerName    = $data['partnerName'];             // TÊN CHỦ VÍ
    $id             = trim($comment);         // TÁCH NỘI DUNG CHUYỂN TIỀN
    $amount         = $data['amount'];
    $finish_time    = $data['clientTime'];
    if ($id) {
        $row = __query("SELECT * FROM `users` WHERE `username` = '$id'")->fetch_array();
        if (isset($row['username'])) {
            if (__query("SELECT * FROM `momo_orders` WHERE `tran_id` = '$tranId' ")->num_rows == 0) {
                $received = $amount;
                foreach($list_recharge_price_momo as $item) {
                    if($item['amount'] == $amount) {
                        $received = $amount + ($amount * $item['bonus'] / 100);
                    }
                }
                $status = 1;
                $create = __insert('momo_orders', [
                    'user_id'      => $row['id'],
                    'tran_id'        => $tranId,
                    'phone'     => $partnerId,
                    'name'   => $partnerName,
                    'message'       => $comment,
                    'amount'        => $amount,
                    'received'      => $received,
                    'status'        => $status,
                    'finish_time'   => $finish_time,
                    'created_at'          => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                if ($create) {

                    __update('users', [
                        'balance' => $row['balance'] + $received
                    ], [
                        'username' => $row['username']
                    ]);
                    $log = $log . 'Đã xử lý giao dịch '.$tranId.' thành công. Cộng '.$received.' vào user '.$id. 'Số dư: '.($row['balance'] + $received) . PHP_EOL;
                }
            }
        } else {
            if (__query("SELECT * FROM `momo_orders` WHERE `tran_id` = '$tranId' ")->num_rows == 0) {
                $received = 0;
                $status = 2;
                $comment = "Không có nội dung";
                $create = __insert('momo_orders', [
                    'tran_id'        => $tranId,
                    'phone'     => $partnerId,
                    'name'   => $partnerName,
                    'message'       => $comment,
                    'amount'        => $amount,
                    'received'      => $received,
                    'status'        => $status,
                    'finish_time'   => $finish_time,
                    'created_at'          => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);
                if ($create) {
                    $log = $log . 'Đã xử lý giao dịch '.$tranId.' thành công. Không tìm thấy user' . PHP_EOL;
                }
            }
        }
    } else {
        if (__query("SELECT * FROM `momo_orders` WHERE `tran_id` = '$tranId' ")->num_rows == 0) {
            $received = 0;
            $status = 2;
            $comment = "Không có nội dung";
            $create = __insert('momo_orders', [
                'tran_id'        => $tranId,
                'phone'     => $partnerId,
                'name'   => $partnerName,
                'message'       => $comment,
                'amount'        => $amount,
                'received'      => $received,
                'status'        => $status,
                'finish_time'   => $finish_time,
                'created_at'          => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
            if ($create) {
                $log = $log . 'Đã xử lý giao dịch '.$tranId.' thành công. Không có nội dung' . PHP_EOL;
            }
        }
    }
} 
$log = $log . "-----------------------------" . PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./momo_cron_logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);
