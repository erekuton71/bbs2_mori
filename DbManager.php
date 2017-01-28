<?php
function getDb() {
    $dsn = 'mysql:dbname=board2;host=localhost';
    $user = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES utf8');
    }   catch (PDOException $e) {
        die("接続エラー:{$e->getMessage()}");
    }
    return $db;
}
