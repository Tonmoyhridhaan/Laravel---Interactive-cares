<?php
    spl_autoload_register(function($className){
        $baseDir = "classes/";
        //var_dump($className);
        require_once $baseDir.$className.'.php';
    });
    
    $car = new Car();
    $bus = new Bus();
    $bike = new Bike();
    
?>