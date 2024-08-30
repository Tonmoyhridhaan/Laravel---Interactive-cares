<?php

class Transaction {
    private $transfersFile = '../db/transfers.txt';
    private $customersFile = '../db/customers.txt';

    public function recordTransfer($fromEmail, $toEmail, $amount) {
        if(config("storage.driver")=="file"){  
            $dateTime = date('Y-m-d H:i:s');
            $record = "$dateTime, From: $fromEmail, To: $toEmail, Amount: " . number_format($amount, 2, '.', '') . PHP_EOL;
            file_put_contents($this->transfersFile, $record, FILE_APPEND);
        }

        if(config("storage.driver")=="mysql"){
            $dateTime = date('Y-m-d H:i:s');
            $sql = "INSERT INTO transfers (dateTime, from_email, to_email, amount) VALUES ('$dateTime','$fromEmail', '$toEmail', $amount)";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
        }
    }

    public function getTransactionsByEmail($email) {
        if(config("storage.driver")=="file"){  
            $transactions = file($this->transfersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $results = [];

            foreach ($transactions as $transaction) {
                list($dateTime, $fromData, $toData, $amountData) = explode(', ', $transaction);
                $fromEmail = trim(str_replace('From: ', '', $fromData));
                $toEmail = trim(str_replace('To: ', '', $toData));
                $amount = trim(str_replace('Amount: ', '', $amountData));

                if ($fromEmail === $email || $toEmail === $email) {
                    $otherEmail = ($fromEmail === $email) ? $toEmail : $fromEmail;
                    $name = getName($otherEmail);
                    $formattedAmount = $fromEmail === $email ? '-' . number_format($amount, 2, '.', '') : '+' . number_format($amount, 2, '.', '');

                    $results[] = [
                        'otherEmail' => $otherEmail,
                        'name' => $name,
                        'amount' => $formattedAmount,
                        'dateTime' => $dateTime
                    ];
                }
            }

            return $results;
        }

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM transfers WHERE from_email='$email' OR to_email='$email'";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $results = [];
            while($row = mysqli_fetch_array($result)){
                $otherEmail = ($row['from_email'] === $email) ? $row['to_email'] : $row['from_email'];
                $name = getName($otherEmail);
                $formattedAmount = $row['from_email'] === $email ? '-' . number_format($row['amount'], 2, '.', '') : '+' . number_format($row['amount'], 2, '.', '');
                $results[] = [
                    'otherEmail' => $otherEmail,
                    'name' => $name,
                    'amount' => $formattedAmount,
                    'dateTime' => $row['dateTime']
                ];
            }
            return $results;
        }
    }
    public function getAllTransactions() {
        if(config("storage.driver")=="file"){
            $transactions = file($this->transfersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $results = [];

            foreach ($transactions as $transaction) {
                list($dateTime, $fromData, $toData, $amountData) = explode(', ', $transaction);
                $fromEmail = trim(str_replace('From: ', '', $fromData));
                $toEmail = trim(str_replace('To: ', '', $toData));
                $amount = trim(str_replace('Amount: ', '', $amountData));

                $fromName = getName($fromEmail);
                $toName = getName($toEmail);

                $results[] = [
                    'fromEmail' => $fromEmail,
                    'fromName' => $fromName,
                    'toEmail' => $toEmail,
                    'toName' => $toName,
                    'amount' => number_format($amount, 2, '.', ''),
                    'dateTime' => $dateTime
                ];
            }

            return $results;
        }

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM transfers";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $results = [];
            while($row = mysqli_fetch_array($result)){
                $fromEmail = $row['from_email'];
                $toEmail = $row['to_email'];
                $fromName = getName($fromEmail);
                $toName = getName($toEmail);
                $results[] = [
                    'fromEmail' => $fromEmail,
                    'fromName' => $fromName,
                    'toEmail' => $toEmail,
                    'toName' => $toName,
                    'amount' => number_format($row['amount'], 2, '.', ''),
                    'dateTime' => $row['dateTime']
                ];
            }
            return $results;
        }
    }

    
}

?>

