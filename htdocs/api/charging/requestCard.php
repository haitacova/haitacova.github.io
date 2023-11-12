<?php

class RequestCard
{
    public function __construct()
    {
    }
    private function isCurl()
    {
        return function_exists('curl_version');
    }

    public function cardCharging($rqId,$serial, $code, $card_type, $amount, $partner_id, $sign, $command)
    {
        try {
            $fields = array(
                "request_id" => $rqId,
                'code' => $code,
                'serial' => $serial,
                'amount' => $amount,
                'telco' => $card_type,
                'partner_id' => $partner_id,
                'sign' => $sign,
                'command' => $command
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
            if ($result['status'] === 99) {
                $return = array(
                    'code' => $result['status'],
                    'text' => $result['message'],
                    'amount' => $result['amount'],
                );
            } else {
                $return = array(
                    // 'code' => $result['status'],
                    // 'text' => $result['message']
                    'code' => 1,
                    'text' => 'Thanh cong',
                    'amount' => '10000',
                );
            }
            return $return;
        } catch (Exception $e) {
            echo '{"code": "01", "text":"Error"}';
            $return = array(
                'code' => "01",
                'text' => "Error"
            );
            return $return;
        }
    }
}