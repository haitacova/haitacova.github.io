<?php

define('NP', true);
require(__DIR__ . '/../../core/configs.php');

$post = json_decode(file_get_contents('php://input'), true);
//Something to write to txt log
$log = "Host: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
        "Content: " . json_encode($post) . PHP_EOL .
        "-------------------------" . PHP_EOL;
file_put_contents('./logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);
//Save string to log, use FILE_APPEND to append.
$statusRq = $post['status'];
$code = $post['code'];
$amount = $post['amount'];


if ($statusRq != null) {
        try {
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
                // Get information charging_orders
                $sqlSl = 'SELECT user_id FROM charging_orders WHERE code="' . $code . '" ';
                $resultSl = SQL()->query($sqlSl);
                if ($resultSl->num_rows <= 0) {
                        return;
                }

                // Update status charging_orders
                $sql = 'UPDATE charging_orders SET status="' . $status . '", updated_at=CURRENT_TIMESTAMP() WHERE code="' . $code . '" ';
                $result = SQL()->query($sql);
                
                // Get balance of user
                $sqlUs = 'SELECT id,balance FROM users WHERE id=' . $resultSl->fetch_assoc()['user_id'] . '';
                $resultUs = SQL()->query($sqlUs);
                $userDB = $resultUs->fetch_assoc();
                $total = $userDB['balance'] + $amount;
                if ($statusRq === 1) {
                        //Update balance of user
                        $sql2 = 'UPDATE users SET balance=' . $total . ' WHERE id=' . $userDB['id'] . '';
                        $result2 = SQL()->query($sql2);

                        // Add to transactions
                        $sqlInsertTrans = 'INSERT INTO transactions (user_id, creator_id, balance_before, balance_change, balance_after,  notes, created_at, updated_at ) VALUES (
            ' . $userDB['id'] . ',  ' . $userDB['id'] . ', ' . $userDB['balance'] . ',  ' . $amount . ', ' . $total . ',"Nạp thẻ cào", CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP())';
                        $resultInsertTrans = SQL()->query($sqlInsertTrans);
                }
        } catch (Exception $e) {
                echo json_encode($e);
        }
}

?>