<?php
define('NP', true);
require(__DIR__ . '/../../core/configs.php');

$log = "Host: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
    "-----------------------CARD CRON START ------" . PHP_EOL;

try {

    $sqlSelect = "SELECT request_id, code, serial, declared_value, telco, real_value, user_id  FROM charging_orders WHERE status='PENDING' ";
    $resultSelect = SQL()->query($sqlSelect);
    if ($resultSelect->num_rows > 0) {
        $listCard = $resultSelect->fetch_all();
        $status = 'ERROR';
        for ($i = 0; $i < sizeof($listCard); $i++) {
            $fields = array(
                "request_id" => $listCard[$i][0],
                'code' => $listCard[$i][1],
                'serial' => $listCard[$i][2],
                'amount' => $listCard[$i][3],
                'telco' => $listCard[$i][4],
                'partner_id' => $configChargingCard['partnerID'],
                'sign' => convertMd5($configChargingCard['partnerKey'], $listCard[$i][1], $listCard[$i][2]),
                'command' => 'check'
            );
            $ch = curl_init("http://api.thegiare.vn/chargingws/v2");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $result = curl_exec($ch);
            $result = json_decode($result, true);
            $statusRq = $result['status'];
            if ($statusRq != null) {
                switch ($statusRq) {
                    case 1:
                        $status = 'SUCCESS';
                        break;
                    case 2:
                        $status = 'CARD_INVALID';
                        break;
                    case 3:
                        $status = 'CARD_ERROR';
                        break;
                    case 4:
                        $status = 'SYSTEM MAINTANCE';
                        break;
                    default:
                        $status = 'PENDING';
                        break;
                }
                // Update status charging_orders
                $sqlUpdate = 'UPDATE charging_orders SET status="' . $status . '", updated_at=CURRENT_TIMESTAMP() WHERE code="' . $listCard[$i][1] . '" ';
                $resultUpdate = SQL()->query($sqlUpdate);

                // Get balance of user
                $sqlUs = 'SELECT id,balance FROM users WHERE id=' . $listCard[$i][6] . '';
                $resultUs = SQL()->query($sqlUs);
                $userDB = $resultUs->fetch_assoc();
                $total = $userDB['balance'] + $listCard[$i][5];
                if ($statusRq === 1) {
                    //Update balance of user
                    $sql2 = 'UPDATE users SET balance=' . $total . ' WHERE id=' . $userDB['id'] . '';
                    $result2 = SQL()->query($sql2);

                    // Add to transactions
                    $sqlInsertTrans = 'INSERT INTO transactions (user_id, creator_id, balance_before, balance_change, balance_after,  notes, created_at, updated_at ) VALUES (
            ' . $userDB['id'] . ',  ' . $userDB['id'] . ', ' . $userDB['balance'] . ',  ' . $listCard[$i][5] . ', ' . $total . ',"Nạp thẻ cào", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())';
                    $resultInsertTrans = SQL()->query($sqlInsertTrans);
                }

            }
            $log = $log . "-----------------------STATUS: " . $status . "\n-----------------------MESSAGE:" . ($statusRq == 1 ? 'SUCCESS' : $result['message']) . " WITH SERIAL: " . $listCard[$i][2] . "  ------";
            //Save string to log, use FILE_APPEND to append.
            sleep(1);
        }
    }
    $log = $log . "\n-----------------------CARD CRON END ------\n" . date("F j, Y, g:i a") . PHP_EOL;

    file_put_contents('./card_cron_logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);
} catch (Exception $e) {
    echo '{"code": "01", "text":"Error"}';
    $log = $log . "-----------------------" . $e . "------" . PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./card_cron_logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);

}

function convertMd5($key, $code, $sr)
{
    return md5($key . $code . $sr);
}

?>