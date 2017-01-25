<?php
require_once 'DbManager.php';
//require_once 'bbs2Validator.php';

//入力データの受け取り
$name = $_POST['name'];
$contents = $_POST['contents'];

/*
//エラー表示
$v = new bbs2Validator();
$v->requiredCheck($_POST['user_id'], 'ユーザID');
$v->requiredCheck($_POST['contents'], '本文');
$v->lengthCheck($_POST['name'], '名前', 255);
$v();

try {
    //データベースへの接続を確立
    $db = getDb();
    //INSERT命令の準備
    $stt = $db->prepare('
    INSERT INTO post_table (name, contents) 
    VALUES (:name, :contents)
    ');
    //INSERT命令にポストデータの内容をセット
    $stt->bindValue(':name', $name);
    $stt->bindValue(':contents', $contents);

    //INSERT命令を実行
    $stt->execute();
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
    //処理後は掲示板トップページにリダイレクト
header('Location: bbs2.php');
