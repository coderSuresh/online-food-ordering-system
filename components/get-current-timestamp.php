<?php
    function getCurrentTimestamp()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Asia/Kathmandu'));
        $date = $date->format('Y-m-d H:i:s');
        return $date;
    }
?>
