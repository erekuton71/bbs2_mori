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

//エラー表示
$v = new signupValidator();
$v->requiredCheck($name, 'ユーザ名');
$v->requiredCheck($password, 'パスワード');
$v->duplicateCheck($name, $name, 'SELECT name FROM member_table WHERE name = :value');
$v->lengthCheck($name, 'ユーザ名', 20);
$v->rangeCheck($password, 'パスワード', 20, 6);
$v->alnumTypeCheck($name, 'ユーザ名');
$v();

try {
    //データベースへの接続を確立
    $db = getDb();
    //INSERT命令の準備
    $stt = $db->prepare('
    INSERT INTO member_table (name, password) 
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
header('Location: signup.php');
?>

</body>
</html>