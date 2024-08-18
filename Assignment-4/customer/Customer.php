<?php

class Customer {
    private $email;
    private $balanceFile = '../db/balance.txt';
    private $customersFile = '../db/customers.txt';

    public function __construct($email) {
        $this->email = $email;
    }

    public function getBalance() {
        $balanceData = file($this->balanceFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($balanceData as $line) {
            list($email, $balance) = explode(', ', $line);
            if (strpos($email, $this->email) !== false) {
                return (float) explode(': ', $balance)[1];
            }
        }
        return 0.00;
    }

    public function updateBalance($amount) {
        $balanceData = file($this->balanceFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $newData = [];
        $found = false;

        foreach ($balanceData as $line) {
            list($email, $balance) = explode(', ', $line);
            if (strpos($email, $this->email) !== false) {
                $newBalance = number_format($this->getBalance() + $amount, 2, '.', '');
                $balance = "Balance: $newBalance";
                $found = true;
            }
            $newData[] = "$email, $balance";
        }

        if (!$found) {
            $newBalance = number_format($amount, 2, '.', '');
            $newData[] = "Email: {$this->email}, Balance: $newBalance";
        }

        file_put_contents($this->balanceFile, implode(PHP_EOL, $newData) . PHP_EOL);
    }

    public function accountExists() {
        $customersData = file($this->customersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($customersData as $line) {
            if (strpos($line, "Email: {$this->email}") !== false) {
                return true;
            }
        }
        return false;
    }
    protected function getNameByEmail($email) {
        $customersData = file($this->customersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($customersData as $line) {
            if (strpos($line, "Email: $email") !== false) {
                preg_match('/Name: ([^,]+)/', $line, $matches);
                return $matches[1] ?? 'Unknown';
            }
        }
        return 'Unknown';
    }
}

?>
