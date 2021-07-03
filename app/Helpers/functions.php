<?php

function str_sanitize($value)
{
    $value = trim($value);
    $value = htmlspecialchars($value);
    $value = stripslashes($value);

    return $value;
}

function throw_error($error)
{
    exit("Error : ". $error->getMessage());
    
}

function format_date($date, $format = 'Y-m-d')
{
    return $date ? date($format, strtotime($date)) : 'N/A';
}

?>
