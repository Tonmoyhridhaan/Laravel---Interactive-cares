<?php
//require "../vendor/autoload.php";
class Customer {
    private $email;
    private $balanceFile = '../db/balance.txt';
    private $customersFile = '../db/customers.txt';

    public function __construct($email) {
        $this->email = $email;
    }

    public function getBalance() {
        if(config("storage.driver")=="file"){  
            $balanceData = file($this->balanceFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($balanceData as $line) {
                list($email, $balance) = explode(', ', $line);
                if (strpos($email, $this->email) !== false) {
                    return (float) explode(': ', $balance)[1];
                }
            }
            return 0.00;
        }

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM balance WHERE email='$this->email'";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            return $row['balance'];
        }
        
    }

    public function updateBalance($amount) {
        if(config("storage.driver")=="file"){  
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

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM balance WHERE email='$this->email'";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $newBalance = $row['balance'] + $amount;
            $sql = "UPDATE balance SET balance=$newBalance WHERE email='$this->email'";
            mysqli_query($con, $sql);
        }
    }

    public function accountExists() {
        if(config("storage.driver")=="file"){  
            $customersData = file($this->customersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($customersData as $line) {
                if (strpos($line, "Email: {$this->email}") !== false) {
                    return true;
                }
            }
            return false;
        }

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM customers WHERE email='$this->email'";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            return $row['email'] == $this->email;
        }
    }
    protected function getNameByEmail($email) {
        if(config("storage.driver")=="file"){  
            $customersData = file($this->customersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($customersData as $line) {
                if (strpos($line, "Email: $email") !== false) {
                    preg_match('/Name: ([^,]+)/', $line, $matches);
                    return $matches[1] ?? 'Unknown';
                }
            }
            return 'Unknown';
        }

        if(config("storage.driver")=="mysql"){
            $sql = "SELECT * FROM customers WHERE email='$email'";
            include '../db/connection.php';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            return $row['name'];
        }

        
    }
}

?>
