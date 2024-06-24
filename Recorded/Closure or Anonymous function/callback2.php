<?php

echo 'Current PHP version: ' . phpversion();


$username = "Tonmoy";

$greetings = [
    "Hello",
    "Merhaba",
    "Adab",
];

//Anonynmous function
// $formattedGreetings = array_map(function ($greeting) use($username){
//     return "$greeting, $username";
// }, $greetings);

//arrow function
$formattedGreetings = array_map(fn ($greeting) => "$greeting, $username!", $greetings);

function display($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

display($formattedGreetings);
?>