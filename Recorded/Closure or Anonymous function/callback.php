<?php
    function greet($name, $customGreeting){
        echo "Hello, $name!";

        $customGreeting();
    }

    greet("Tonmoy", function(){
        $time = date('h:i');

        echo "Have a great day! It's {$time}";
    });


?>