<?php
require_once 'DbManager.php';
require_once 'bbs2Validator.php';
session_start();
// ログイン状態のチェック
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

//入力データの受け取り
$name = $_POST['name'];
$contents = $_POST['contents'];

//エラー表示
$v = new bbs2Validator();
//$v->requiredCheck($_POST['user_id'], 'ユーザID');
$v->requiredCheck($_POST['contents'], '本文');
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
    //処理後は掲示板投稿ページにリダイレクト
header('Location: bbs2.php');
