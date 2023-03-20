<?php
date_default_timezone_set('Asia/Kathmandu');
function getCurrentTimestamp()
{
    $date = date('Y-m-d H:i:s');
    return $date;
}

function getCurrentDate()
{
    $date = date('Y-m-d');
    return $date;
}

function getCurrentTime()
{
    $time = date('H:i');
    return $time;
}