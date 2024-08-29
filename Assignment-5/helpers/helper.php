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


function getFirstLetters($fullname){
    $name = explode(" ", $fullname);
    $first_name = $name[0];
    $last_name = $name[1];
    $first_letters = substr($first_name, 0, 1) . substr($last_name, 0, 1);
    return $first_letters;
}

function getBalance($email){
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


?>