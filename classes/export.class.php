<?php

class Export
{
    public static function toCSV($filename, $data) {
        foreach($data as $string) {
            file_put_contents($filename . '.csv', implode(';', $string) . "\r\n", FILE_APPEND | LOCK_EX);
        }
    }

    public static function toJSON($filename, $data) {
        file_put_contents($filename . '.json', json_encode($data, JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}

 ?>
