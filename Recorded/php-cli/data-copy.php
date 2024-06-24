#!/usr/bin/env php
<?php
    $longoptions = ["from:", "to::"];

    $options = getopt( "", $longoptions );
    $from = $options["from"];
    $to = $options["to"];

    $contents = file_get_contents($from);
    file_put_contents($to, $contents);



?>
