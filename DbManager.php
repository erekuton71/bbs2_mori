<?php
function getDb() {
    $dsn = 'mysql:dbname=board1_db;host=localhost';
    $user = 'root';
    $password = '';

    try {
        //データベースへの接続を確立
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //データベース接続時に使用する文字コードをutf8に設定
        $db->exec('SET NAMES utf8');
    }   catch (PDOException $e) {
        die("接続エラー:{$e->getMessage()}");
    }
    return $db;
}
