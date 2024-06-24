#!/usr/bin/env php
<?php

//Shebang -----

// $from = $argv[1];
// $to = $argv[2];

//options------- start
$shortoptions = "f:t::";
$longoptions = ["from:", "to::"];

$options = getopt( "", $longoptions );
$from = $options["from"];
$to = $options["to"];
//options-------- end
for($i=$from; $i<=$to; $i++){
    echo $i . PHP_EOL;
}

//var_dump(php_sapi_name());
?>