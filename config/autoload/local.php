<?php
$dbName = 'speroteck';
$dbhost = 'localhost';
$dbUser = 'root';
$dbPwd = 'pass';

return array(
    'db' => array(
        'driver'   => 'Pdo',
        'dsn'      => 'mysql:dbname='.$dbName.';host='.$dbhost,
        'username' => $dbUser,
        'password' => $dbPwd,
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    )
);