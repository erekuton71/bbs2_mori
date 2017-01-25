<?php
require_once 'DbManager.php';
require_once 'signupValidator.php';
?>

<!DOCTYPE html>
<html lang="ja">
<html>
<meta charset="UTF-8">
<head><title>新規登録　テクアカ課題BBS2</title></head>
<body>
<h1 aligin="center">テクアカ課題BBS2</h1>
<hr />
<a  href="signup.php">新規登録ページに戻る</a>

<?php
//入力データの受け取り
$name = $_POST['name'];
$password = $_POST['password'];

//passwordのハッシュ化
$hashpass = password_hash($_POST['password'],PASSWORD_DEFAULT);

//エラー表示
$v = new signupValidator();
$v->requiredCheck($name, 'ユーザ名');
$v->alnumTypeCheck($name, 'ユーザ名');
$v->lengthCheck($name, 'ユーザ名', 20);
$v->duplicateCheck($name, $name, 'SELECT name FROM member WHERE name = :value');
$v->requiredCheck($password, 'パスワード');
$v->rangeCheck($password, 'パスワード', 20, 6);
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
    $stt->bindValue(':password', $hashpass);

    //INSERT命令を実行
    $stt->execute();
    $db = NULL;
}   catch (PDOException $e) {
    die("エラーメッセージ: {$e->getMessage()}");
}
//処理後は掲示板トップページにリダイレクト
header('Location: signup.php');
?>

</body>
</html>