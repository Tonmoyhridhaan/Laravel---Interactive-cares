<?php
    //Anonymous function or lamda function

    $years = [2002, 2003, 2004, 2005];

    $incrementYear = function ($year){
        return $year += 10;
    };

    $updatedYears = array_map($incrementYear, $years);

    print_r($updatedYears);

?>