<?php

### DONT TOUCH IN THIS CODE ###
### WORKING FINE 19/08/2006 ###
###       IVENSPONTES       ###
### github.com/ivenspontes/ ###

header("access-control-allow-origin: https://pagseguro.uol.com.br");
require_once 'custom_scripts/PagSeguroLibrary/PagSeguroLibrary.php';
require 'config/config.php';

$method = $_SERVER['REQUEST_METHOD'];

if('POST' == $method){

    $type = $_POST['notificationType'];

    $notificationCode = $_POST['notificationCode'];

    if ($type === 'transaction'){

        try {
            $credentials = PagSeguroConfig::getAccountCredentials();
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);

            $arrayPDO['transaction_code'] = $transaction->getCode();
            $arrayPDO['name'] = $transaction->getReference();
            $arrayPDO['payment_method'] = $transaction->getPaymentMethod()->getType()->getTypeFromValue();
            $arrayPDO['status'] = $transaction->getStatus()->getTypeFromValue();
            $item = $transaction->getItems();
            $arrayPDO['item_count'] = $item[0]->getQuantity();
            $date_now = date('Y-m-d H:i:s');
            $arrayPDO['data'] = $date_now;

            try {
                $conn = new PDO('mysql:host='.$config['pagSeguro']['host'].';dbname='.$config['pagSeguro']['database'].'', $config['pagSeguro']['databaseUser'], $config['pagSeguro']['databasePass']);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare('INSERT into pagseguro_transactions SET transaction_code = :transaction_code, name = :name, payment_method = :payment_method, status = :status, item_count = :item_count, data = :data');
                $stmt->execute($arrayPDO);

                if ($arrayPDO['status'] == 'PAID') {
                    if ($config['pagSeguro']['doublePoints']) {
                        $arrayPDO['item_count'] = $arrayPDO['item_count']*2;
                    }
                    $stmt = $conn->prepare('UPDATE accounts SET premium_points = premium_points + :item_count WHERE name = :name');
                    $stmt->execute(array('item_count' => $arrayPDO['item_count'], 'name' => $arrayPDO['name']));

                    $stmt = $conn->prepare("UPDATE pagseguro_transactions SET status = 'DELIVERED' WHERE transaction_code = :transaction_code AND status = 'PAID'");
                    $stmt->execute(array('transaction_code' => $arrayPDO['transaction_code']));
                }

            } catch(PDOException $e) {
                echo 'ERROR: ' . $e->getMessage();
            }

        } catch(PagSeguroServiceException $e) {
            die($e->getMessage());
        }


    }
}
