<?php

namespace App\Persistence;

abstract class Record
{
    protected static $connection;

    protected static function connect()
    {
        // TODO: MOVE!
        $driver = getenv('DB_DRIVER');
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_NAME');
        $uname = getenv('DB_USERNAME');
        $pword = getenv('DB_PASSWORD');
        $db = new PdoDatabase($driver, $host, $port, $dbname, $uname, $pword);
        return $db->connection();
    }
}