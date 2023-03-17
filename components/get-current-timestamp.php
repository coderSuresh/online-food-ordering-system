<?php
    function getCurrentTimestamp()
    {
        date_default_timezone_set('Asia/Kathmandu');
        $date = date('Y-m-d H:i:s');
        return $date;
    }
