<?php

define('NP', true);
require(__DIR__ . '/../../core/configs.php');
$post = json_decode(file_get_contents('php://input'), true);
//Something to write to txt log
$log = "Host: " . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
    "Content LOGIN: " . json_encode($post) . PHP_EOL .
    "-------------------------" . PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./logs/log_' . date("j.n.Y") . '.log', $log, FILE_APPEND);

try {
    session_start();
    $user = $_SESSION['user'];
    $sql = "SELECT telco, declared_value, real_value, status, created_at FROM charging_orders WHERE user_id = " . $user['id'] . " ORDER BY created_at desc";
    
    $rows = SQL()->query($sql);
    echo json_encode($rows->fetch_all());
    if ($rows != false && $rows->num_rows > 0) {
        return json_encode($rows->fetch_all());
    }
} catch (Exception $e) {
    echo json_decode($e);
}