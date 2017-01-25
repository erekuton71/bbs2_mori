<?php
require_once 'DbManager.php';
require_once 'loginValidator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>ログイン　テクアカ課題BBS2</title></head>
<body>
<h1 aligin="center">テクアカ課題BBS2</h1>
<hr />
<a  href="index.php">ログインページに戻る</a>

<?php
//入力データの受け取り
$name = $_POST['name'];
$password = $_POST['password'];

//エラー表示
$v = new loginValidator();
$v->requiredCheck($name, 'ユーザ名');
$v->requiredCheck($password, 'パスワード');
$v();

try {
    //データベースへの接続を確立
    $db = getDb();
    //INSERT命令の準備
    $stt = $db->prepare('
    INSERT INTO member (name, password) 
    VALUES (:name, :password)
    ');
    //INSERT命令にポストデータの内容をセット
    $stt->bindValue(':name', $name);
    $stt->bindValue(':password', $password);

    //INSERT命令を実行
    $stt->execute();
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
//処理後は掲示板トップページにリダイレクト
//header('Location: bbs2.php');
?>

</body>
</html>