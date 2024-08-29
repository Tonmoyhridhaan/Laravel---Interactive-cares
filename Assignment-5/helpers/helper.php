<?php

function sanitize(string $data): string
{
    return htmlspecialchars(stripslashes(trim($data)));
}
function flash($key, $message = null)
{
    if ($message) {
        $_SESSION['flash'][$key] = $message;
    }
    else if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
}


function getName($useremail){
    if(config("storage.driver")=="file"){  
        $file_path = '../db/customers.txt';
        if (file_exists($file_path)) {
            $file = fopen("../db/customers.txt", "r");
            if ($file) {
                while (($line = fgets($file)) !== false) {
                    list($name, $email, $password) = explode(", ", trim($line));
                    $email = str_replace("Email: ", "", $email);
                    if($useremail == $email){
                        return explode(": ",$name)[1];
                    }
                }
                fclose($file);
            }
        }
    }

    if(config("storage.driver")=="mysql"){
        
        $sql = "SELECT * FROM customers WHERE email='$useremail'";
        include '../db/connection.php';
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        return $row['name'];
    }
}


function getFirstLetters($fullname){
    $name = explode(" ", $fullname);
    $first_name = $name[0];
    $last_name = $name[1];
    $first_letters = substr($first_name, 0, 1) . substr($last_name, 0, 1);
    return $first_letters;
}

function getBalance($email){
    if(config("storage.driver")=="file"){  
        $file_path = '../db/balance.txt';
        if (file_exists($file_path)) {
            $file = fopen("../db/balance.txt", "r");
            if ($file) {
                while (($line = fgets($file)) !== false) {
                    list($stored_email, $balance) = explode(", ", trim($line));
                    $stored_email = str_replace("Email: ", "", $stored_email);
                    if($email == $stored_email){
                        return explode(': ',$balance)[1];
                    }
                }
                fclose($file);
            }
        }
    }
    if(config("storage.driver")=="mysql"){
        $sql = "SELECT * FROM balance WHERE email='$email'";
        include '../db/connection.php';
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        return $row['balance'];
    }
}
function config($key) {
    $parts = explode('.', $key);
    $file = __DIR__ . '/../config/' . $parts[0] . '.php';

    if (file_exists($file)) {
        $config = include($file);

        if (isset($config[$parts[1]])) {
            return $config[$parts[1]];
        }
    }

    return null;
}
function insertCustomerDB($name, $email, $password){
    include 'db/connection.php';
    
    $sql = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')";
    
    if (mysqli_query($con, $sql)) {
        
        $sql = "INSERT INTO balance (email, balance) VALUES ('$email',0)";
        if (mysqli_query($con,$sql)) {
            return True;
        }
    }

}


?>